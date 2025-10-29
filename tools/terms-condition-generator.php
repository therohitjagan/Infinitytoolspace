<?php
// Initialize variables
$companyName = isset($_POST['companyName']) ? $_POST['companyName'] : '';
$websiteName = isset($_POST['websiteName']) ? $_POST['websiteName'] : '';
$websiteUrl = isset($_POST['websiteUrl']) ? $_POST['websiteUrl'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$effectiveDate = isset($_POST['effectiveDate']) ? $_POST['effectiveDate'] : date('F d, Y');
$userGeneration = isset($_POST['userGeneration']) ? $_POST['userGeneration'] : false;
$contentGeneration = isset($_POST['contentGeneration']) ? $_POST['contentGeneration'] : false;
$ecommerce = isset($_POST['ecommerce']) ? $_POST['ecommerce'] : false;
$payments = isset($_POST['payments']) ? $_POST['payments'] : false;
$intellectual = isset($_POST['intellectual']) ? $_POST['intellectual'] : false;
$indemnification = isset($_POST['indemnification']) ? $_POST['indemnification'] : false;
$termination = isset($_POST['termination']) ? $_POST['termination'] : false;
$governing = isset($_POST['governing']) ? $_POST['governing'] : '';
$arbitration = isset($_POST['arbitration']) ? $_POST['arbitration'] : false;
$updates = isset($_POST['updates']) ? $_POST['updates'] : false;
$contactInfo = isset($_POST['contactInfo']) ? $_POST['contactInfo'] : true;

// Generate Terms and Conditions when form is submitted
$termsContent = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    $termsContent = generateTerms(
        $companyName,
        $websiteName,
        $websiteUrl,
        $email,
        $effectiveDate,
        $userGeneration,
        $contentGeneration,
        $ecommerce,
        $payments,
        $intellectual,
        $indemnification,
        $termination,
        $governing,
        $arbitration,
        $updates,
        $contactInfo
    );
}

// Function to generate Terms and Conditions
function generateTerms($companyName, $websiteName, $websiteUrl, $email, $effectiveDate, 
                      $userGeneration, $contentGeneration, $ecommerce, $payments, 
                      $intellectual, $indemnification, $termination, $governing, 
                      $arbitration, $updates, $contactInfo) {
    
    $terms = "<h2>Terms and Conditions</h2>";
    $terms .= "<p>Effective Date: $effectiveDate</p>";
    $terms .= "<p>Welcome to $websiteName. These Terms and Conditions govern your use of our website located at $websiteUrl (the \"Service\") operated by $companyName.</p>";
    $terms .= "<p>By accessing or using the Service, you agree to be bound by these Terms. If you disagree with any part of the terms, you may not access the Service.</p>";
    
    // Introduction
    $terms .= "<h3>1. Introduction</h3>";
    $terms .= "<p>By using our website, you confirm that you accept these terms of use and that you agree to comply with them. If you do not agree to these terms, you must not use our website.</p>";
    
    // User Accounts section
    if ($userGeneration) {
        $terms .= "<h3>2. User Accounts</h3>";
        $terms .= "<p>When you create an account with us, you must provide information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.</p>";
        $terms .= "<p>You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password.</p>";
        $terms .= "<p>You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>";
    }
    
    // User-Generated Content
    if ($contentGeneration) {
        $terms .= "<h3>3. User-Generated Content</h3>";
        $terms .= "<p>Our Service may allow you to post, link, store, share and otherwise make available certain information, text, graphics, videos, or other material. By providing User-Generated Content, you grant us the right to use, modify, publicly perform, publicly display, reproduce, and distribute such content on and through the Service.</p>";
        $terms .= "<p>You are responsible for the content you post. You should not post content that violates the law, infringes on the rights of others, is offensive, or otherwise violates these Terms.</p>";
    }
    
    // E-commerce
    if ($ecommerce) {
        $terms .= "<h3>4. E-commerce</h3>";
        $terms .= "<p>Products or services offered for sale through our Service are described as accurately as possible. However, we do not warrant that product descriptions or other content on this site is accurate, complete, reliable, current, or error-free.</p>";
        $terms .= "<p>We reserve the right to refuse any order you place with us. We may, in our sole discretion, limit or cancel quantities purchased per person, per household, or per order.</p>";
        $terms .= "<p>Prices for our products are subject to change without notice. We reserve the right at any time to modify or discontinue the Service (or any part or content thereof) without notice at any time.</p>";
    }
    
    // Payments
    if ($payments) {
        $terms .= "<h3>5. Payments</h3>";
        $terms .= "<p>All payments are processed securely through our payment processors. By providing your payment information, you represent and warrant that you have the legal right to use any payment method(s) in connection with any purchase.</p>";
        $terms .= "<p>You agree to provide current, complete, and accurate purchase and account information for all purchases made via the Service.</p>";
        $terms .= "<p>We reserve the right to refuse or cancel your order if fraud or an unauthorized or illegal transaction is suspected.</p>";
    }
    
    // Intellectual Property
    if ($intellectual) {
        $terms .= "<h3>6. Intellectual Property</h3>";
        $terms .= "<p>The Service and its original content, features, and functionality are and will remain the exclusive property of $companyName and its licensors.</p>";
        $terms .= "<p>Our trademarks and trade dress may not be used in connection with any product or service without the prior written consent of $companyName.</p>";
    }
    
    // Indemnification
    if ($indemnification) {
        $terms .= "<h3>7. Indemnification</h3>";
        $terms .= "<p>You agree to defend, indemnify, and hold harmless $companyName, its affiliates, licensors, and service providers, and its and their respective officers, directors, employees, contractors, agents, licensors, suppliers, successors, and assigns from and against any claims, liabilities, damages, judgments, awards, losses, costs, expenses, or fees (including reasonable attorneys' fees) arising out of or relating to your violation of these Terms or your use of the Service.</p>";
    }
    
    // Termination
    if ($termination) {
        $terms .= "<h3>8. Termination</h3>";
        $terms .= "<p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>";
        $terms .= "<p>Upon termination, your right to use the Service will immediately cease. If you wish to terminate your account, you may simply discontinue using the Service or contact us to request account deletion.</p>";
    }
    
    // Governing Law
    if (!empty($governing)) {
        $terms .= "<h3>9. Governing Law</h3>";
        $terms .= "<p>These Terms shall be governed and construed in accordance with the laws of $governing, without regard to its conflict of law provisions.</p>";
    }
    
    // Arbitration
    if ($arbitration) {
        $terms .= "<h3>10. Dispute Resolution</h3>";
        $terms .= "<p>Any dispute arising from or relating to the subject matter of this Agreement shall be finally settled by arbitration. The arbitration will be conducted in accordance with the rules of the American Arbitration Association.</p>";
        $terms .= "<p>The arbitration shall be held in " . (!empty($governing) ? $governing : "the location determined by the arbitrator") . ".</p>";
    }
    
    // Updates to Terms
    if ($updates) {
        $terms .= "<h3>11. Changes to Terms</h3>";
        $terms .= "<p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will try to provide at least 30 days' notice prior to any new terms taking effect.</p>";
        $terms .= "<p>What constitutes a material change will be determined at our sole discretion. By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms.</p>";
    }
    
    // Contact Information
    if ($contactInfo) {
        $terms .= "<h3>12. Contact Us</h3>";
        $terms .= "<p>If you have any questions about these Terms, please contact us at:</p>";
        $terms .= "<p>$companyName<br>";
        if (!empty($email)) {
            $terms .= "Email: $email<br>";
        }
        $terms .= "Website: $websiteUrl</p>";
    }
    
    return $terms;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Terms and Conditions Generator</title>
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: var(--dark-color);
            background-color: #f8f9fa;
            line-height: 1.6;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 3rem 0;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .hero-title {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-weight: 300;
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .form-container {
            padding: 2rem 1rem;
            margin-top: 1rem;
        }
        
        .section-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent-color);
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 0.6rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .terms-output {
            padding: 2rem 1rem;
            margin-top: 2rem;
        }
        
        .terms-output h2, .terms-output h3 {
            color: var(--secondary-color);
        }
        
        .terms-output h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .terms-output h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.8rem;
        }
        
        .terms-output p {
            margin-bottom: 1rem;
            color: #444;
        }
        
        .terms-controls {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        
        .copy-success {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 0.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.8rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .form-container, .terms-output {
                padding: 1rem 0.5rem;
            }
            
            .terms-controls {
                justify-content: center;
            }
            
            .btn {
                margin-bottom: 0.5rem;
                width: 100%;
            }
            
            .section-title {
                font-size: 1.4rem;
            }
        }
        
        /* Extra small devices */
        @media (max-width: 576px) {
            .hero-section {
                padding: 2rem 0;
            }
            
            .hero-title {
                font-size: 1.5rem;
            }
            
            .hero-subtitle {
                font-size: 0.9rem;
                padding: 0 1rem;
            }
            
            .col-md-6 {
                margin-bottom: 0.5rem;
            }
        }

        /* Tooltip styling */
        .tooltip-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            background-color: #6c757d;
            color: white;
            text-align: center;
            border-radius: 50%;
            font-size: 12px;
            line-height: 16px;
            margin-left: 5px;
            cursor: help;
        }

        .tooltip-text {
            visibility: hidden;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.8rem;
            width: 200px;
        }

        .tooltip-container {
            position: relative;
            display: inline-block;
        }

        .tooltip-container:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Loader */
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid var(--primary-color);
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsive content */
        #termsContent {
            word-wrap: break-word;
            overflow-wrap: break-word;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="hero-title">Terms and Conditions Generator - Infinitytoolspace</h1>
            <p class="hero-subtitle">Create professional Terms and Conditions for your website in minutes. Customize to your business needs.</p>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-container">
                    <form method="post" id="termsForm">
                        <h2 class="section-title">Business Information</h2>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="companyName" class="form-label">Company Name*</label>
                                <input type="text" class="form-control" id="companyName" name="companyName" value="<?php echo htmlspecialchars($companyName); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="websiteName" class="form-label">Website Name*</label>
                                <input type="text" class="form-control" id="websiteName" name="websiteName" value="<?php echo htmlspecialchars($websiteName); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="websiteUrl" class="form-label">Website URL*</label>
                                <input type="url" class="form-control" id="websiteUrl" name="websiteUrl" value="<?php echo htmlspecialchars($websiteUrl); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Contact Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="effectiveDate" class="form-label">Effective Date</label>
                                <input type="date" class="form-control" id="effectiveDate" name="effectiveDate" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="governing" class="form-label">Governing Law (State/Country)</label>
                                <input type="text" class="form-control" id="governing" name="governing" value="<?php echo htmlspecialchars($governing); ?>" placeholder="e.g., California, USA">
                            </div>
                        </div>

                        <h2 class="section-title">Content Sections</h2>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="userGeneration" name="userGeneration" <?php echo $userGeneration ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="userGeneration">
                                        User Accounts
                                        <div class="tooltip-container">
                                            <span class="tooltip-icon">?</span>
                                            <span class="tooltip-text">Include terms for user registration, account management, and user responsibilities.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="contentGeneration" name="contentGeneration" <?php echo $contentGeneration ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="contentGeneration">
                                        User-Generated Content
                                        <div class="tooltip-container">
                                            <span class="tooltip-icon">?</span>
                                            <span class="tooltip-text">Include terms for user posts, comments, and other content submissions.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ecommerce" name="ecommerce" <?php echo $ecommerce ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="ecommerce">
                                        E-commerce
                                        <div class="tooltip-container">
                                            <span class="tooltip-icon">?</span>
                                            <span class="tooltip-text">Include terms for online sales, product descriptions, pricing, and ordering.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="payments" name="payments" <?php echo $payments ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="payments">
                                        Payments
                                        <div class="tooltip-container">
                                            <span class="tooltip-icon">?</span>
                                            <span class="tooltip-text">Include terms for payment processing, refunds, and billing information.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="intellectual" name="intellectual" <?php echo $intellectual ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="intellectual">
                                        Intellectual Property
                                        <div class="tooltip-container">
                                            <span class="tooltip-icon">?</span>
                                            <span class="tooltip-text">Include terms for trademarks, copyrights, and other intellectual property rights.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="indemnification" name="indemnification" <?php echo $indemnification ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="indemnification">
                                        Indemnification
                                        <div class="tooltip-container">
                                            <span class="tooltip-icon">?</span>
                                            <span class="tooltip-text">Include terms for user liability and responsibility for legal claims.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="termination" name="termination" <?php echo $termination ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="termination">
                                        Termination
                                        <div class="tooltip-container">
                                            <span class="tooltip-icon">?</span>
                                            <span class="tooltip-text">Include terms for account suspension, termination, and service discontinuation.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="arbitration" name="arbitration" <?php echo $arbitration ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="arbitration">
                                        Dispute Resolution
                                        <div class="tooltip-container">
                                            <span class="tooltip-icon">?</span>
                                            <span class="tooltip-text">Include terms for arbitration and legal dispute resolution procedures.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="updates" name="updates" <?php echo $updates ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="updates">
                                        Terms Updates
                                        <div class="tooltip-container">
                                            <span class="tooltip-icon">?</span>
                                            <span class="tooltip-text">Include information about how and when terms may be updated.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="contactInfo" name="contactInfo" <?php echo $contactInfo ? 'checked' : ''; ?> checked>
                                    <label class="form-check-label" for="contactInfo">
                                        Contact Information
                                        <div class="tooltip-container">
                                            <span class="tooltip-icon">?</span>
                                            <span class="tooltip-text">Include company contact details for inquiries about the terms.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mb-3">
                            <div class="loader" id="generateLoader"></div>
                            <button type="submit" name="generate" class="btn btn-primary" id="generateBtn">
                                <i class="bi bi-file-earmark-text"></i> Generate Terms and Conditions
                            </button>
                        </div>
                    </form>
                </div>
                
                <?php if (!empty($termsContent)): ?>
                <div class="terms-output" id="termsOutput">
                    <div class="copy-success" id="copySuccess">Terms and Conditions copied to clipboard!</div>
                    <div class="terms-controls">
                        <button class="btn btn-sm btn-outline-primary" id="copyBtn">
                            <i class="bi bi-clipboard"></i> Copy to Clipboard
                        </button>
                        <button class="btn btn-sm btn-outline-primary" id="downloadBtn">
                            <i class="bi bi-download"></i> Download as HTML
                        </button>
                    </div>
                    <div id="termsContent">
                        <?php echo $termsContent; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- SEO Optimization -->
    <div style="display:none">
        <h1>Terms and Conditions Generator Tool</h1>
        <h2>Create Free, Custom Terms and Conditions for Your Website</h2>
        <p>Generate professional, legally-sound Terms and Conditions for your website or online business. Our free generator creates custom Terms and Conditions tailored to your business needs. Protect your company with clear user agreements covering user accounts, content policies, intellectual property, payments, and more.</p>
        <p>Keywords: terms and conditions generator, terms of service generator, terms and conditions template, website legal documents, free legal terms, website terms of use, website legal requirements, ecommerce terms and conditions, GDPR terms and conditions</p>
    </div>

    <!-- Bootstrap and JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission with loader
            const termsForm = document.getElementById('termsForm');
            const generateBtn = document.getElementById('generateBtn');
            const generateLoader = document.getElementById('generateLoader');
            
            if (termsForm) {
                termsForm.addEventListener('submit', function() {
                    generateBtn.style.display = 'none';
                    generateLoader.style.display = 'block';
                });
            }
            
            // Copy to clipboard functionality
            const copyBtn = document.getElementById('copyBtn');
            const copySuccess = document.getElementById('copySuccess');
            const termsContent = document.getElementById('termsContent');
            
            if (copyBtn && termsContent) {
                copyBtn.addEventListener('click', function() {
                    const range = document.createRange();
                    range.selectNode(termsContent);
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                    document.execCommand('copy');
                    window.getSelection().removeAllRanges();
                    
                    copySuccess.style.display = 'block';
                    setTimeout(function() {
                        copySuccess.style.display = 'none';
                    }, 3000);
                });
            }
            
            // Download as HTML functionality
            const downloadBtn = document.getElementById('downloadBtn');
            
            if (downloadBtn && termsContent) {
                downloadBtn.addEventListener('click', function() {
                    const htmlContent = `
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Terms and Conditions</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                line-height: 1.6;
                                color: #333;
                                max-width: 800px;
                                margin: 0 auto;
                                padding: 20px;
                            }
                            h2 {
                                color: #2c3e50;
                                border-bottom: 1px solid #eee;
                                padding-bottom: 10px;
                                font-size: 1.8rem;
                                font-weight: 700;
                                margin-bottom: 1rem;
                            }
                            h3 {
                                color: #3a4b5c;
                                font-size: 1.3rem;
                                font-weight: 600;
                                margin-top: 1.5rem;
                                margin-bottom: 0.8rem;
                            }
                            p {
                                margin-bottom: 1rem;
                            }
                        </style>
                    </head>
                    <body>
                        ${termsContent.innerHTML}
                    </body>
                    </html>
                    `;
                    
                    const blob = new Blob([htmlContent], { type: 'text/html' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'terms-and-conditions.html';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                });
            }
            
            // Link the ecommerce and payments checkboxes
            const ecommerceCheckbox = document.getElementById('ecommerce');
            const paymentsCheckbox = document.getElementById('payments');
            
            if (ecommerceCheckbox && paymentsCheckbox) {
                ecommerceCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        paymentsCheckbox.checked = true;
                    }
                });
            }
            
            // Form validation
            const companyNameInput = document.getElementById('companyName');
            const websiteNameInput = document.getElementById('websiteName');
            const websiteUrlInput = document.getElementById('websiteUrl');
            
            if (termsForm) {
                termsForm.addEventListener('submit', function(event) {
                    let isValid = true;
                    
                    if (!companyNameInput.value.trim()) {
                        companyNameInput.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        companyNameInput.classList.remove('is-invalid');
                    }
                    
                    if (!websiteNameInput.value.trim()) {
                        websiteNameInput.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        websiteNameInput.classList.remove('is-invalid');
                    }
                    
                    if (!websiteUrlInput.value.trim() || !isValidUrl(websiteUrlInput.value)) {
                        websiteUrlInput.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        websiteUrlInput.classList.remove('is-invalid');
                    }
                    
                    if (!isValid) {
                        event.preventDefault();
                    }
                });
            }
            
            function isValidUrl(string) {
                try {
                    new URL(string);
                    return true;
                } catch (_) {
                    return false;
                }
            }
            
            // Autofill URL protocol if missing
            if (websiteUrlInput) {
                websiteUrlInput.addEventListener('blur', function() {
                    const url = this.value.trim();
                    if (url && !url.match(/^https?:\/\//i)) {
                        this.value = 'https://' + url;
                    }
                });
            }
            
            // Responsive adjustments
            function handleResponsiveLayout() {
                const windowWidth = window.innerWidth;
                const tooltips = document.querySelectorAll('.tooltip-text');
                
                if (windowWidth < 768) {
                    tooltips.forEach(tooltip => {
                        tooltip.style.width = '160px';
                        tooltip.style.marginLeft = '-80px';
                    });
                } else {
                    tooltips.forEach(tooltip => {
                        tooltip.style.width = '200px';
                        tooltip.style.marginLeft = '-100px';
                    });
                }
            }
            
            // Initial call and event listener
            handleResponsiveLayout();
            window.addEventListener('resize', handleResponsiveLayout);
            
            // Smooth scroll to results
            const termsOutput = document.getElementById('termsOutput');
            if (termsOutput) {
                termsOutput.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    </script>

    <!-- Schema.org structured data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebApplication",
        "name": "Terms and Conditions Generator",
        "description": "Create professional, legally-sound Terms and Conditions for your website or online business.",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "All",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
        }
    }
    </script>
</body>
</html>
<?php include("../footer.php")?>