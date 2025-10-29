<?php
// Privacy Policy Generator Tool
// Filename: privacy-policy-generator.php

// Initialize variables
$company_name = $website_url = $contact_email = $effective_date = '';
$collect_personal_info = $collect_cookies = $collect_analytics = $collect_payments = false;
$third_party_services = $share_data = false;
$has_newsletter = $has_account = $has_comments = false;
$data_retention = "We retain your personal data for as long as necessary to provide you with our services and as necessary to comply with our legal obligations.";
$user_rights = true;
$privacy_policy = '';
$error = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (empty($_POST['company_name']) || empty($_POST['website_url']) || empty($_POST['contact_email']) || empty($_POST['effective_date'])) {
        $error = "Please fill out all required fields.";
    } else {
        // Get form data
        $company_name = htmlspecialchars($_POST['company_name']);
        $website_url = htmlspecialchars($_POST['website_url']);
        $contact_email = htmlspecialchars($_POST['contact_email']);
        $effective_date = htmlspecialchars($_POST['effective_date']);
        
        // Get checkbox values
        $collect_personal_info = isset($_POST['collect_personal_info']);
        $collect_cookies = isset($_POST['collect_cookies']);
        $collect_analytics = isset($_POST['collect_analytics']);
        $collect_payments = isset($_POST['collect_payments']);
        $third_party_services = isset($_POST['third_party_services']);
        $share_data = isset($_POST['share_data']);
        $has_newsletter = isset($_POST['has_newsletter']);
        $has_account = isset($_POST['has_account']);
        $has_comments = isset($_POST['has_comments']);
        $user_rights = isset($_POST['user_rights']);
        
        if (!empty($_POST['data_retention'])) {
            $data_retention = htmlspecialchars($_POST['data_retention']);
        }
        
        // Generate Privacy Policy
        $privacy_policy = generatePrivacyPolicy(
            $company_name, 
            $website_url, 
            $contact_email, 
            $effective_date, 
            $collect_personal_info,
            $collect_cookies,
            $collect_analytics,
            $collect_payments,
            $third_party_services,
            $share_data,
            $has_newsletter,
            $has_account,
            $has_comments,
            $data_retention,
            $user_rights
        );
    }
}

function generatePrivacyPolicy($company_name, $website_url, $contact_email, $effective_date, $collect_personal_info, $collect_cookies, $collect_analytics, $collect_payments, $third_party_services, $share_data, $has_newsletter, $has_account, $has_comments, $data_retention, $user_rights) {
    $policy = "<h1>Privacy Policy</h1>";
    $policy .= "<p>Last updated: {$effective_date}</p>";
    $policy .= "<h2>Introduction</h2>";
    $policy .= "<p>Welcome to {$company_name} (\"we,\" \"our,\" or \"us\"). We respect your privacy and are committed to protecting your personal data. This privacy policy will inform you about how we look after your personal data when you visit our website {$website_url} (regardless of where you visit it from) and tell you about your privacy rights and how the law protects you.</p>";
    
    $policy .= "<h2>1. Important Information and Who We Are</h2>";
    $policy .= "<p>{$company_name} is the controller and responsible for your personal data. If you have any questions about this privacy policy, including any requests to exercise your legal rights, please contact us at {$contact_email}.</p>";
    
    if ($collect_personal_info) {
        $policy .= "<h2>2. The Data We Collect About You</h2>";
        $policy .= "<p>Personal data, or personal information, means any information about an individual from which that person can be identified. We may collect, use, store and transfer different kinds of personal data about you which we have grouped together as follows:</p>";
        $policy .= "<ul>";
        $policy .= "<li><strong>Identity Data</strong> includes first name, last name, username or similar identifier.</li>";
        $policy .= "<li><strong>Contact Data</strong> includes email address and telephone numbers.</li>";
        
        if ($has_account) {
            $policy .= "<li><strong>Account Data</strong> includes your username and password, purchases or orders made by you, your preferences, and feedback.</li>";
        }
        
        if ($collect_analytics) {
            $policy .= "<li><strong>Technical Data</strong> includes internet protocol (IP) address, your login data, browser type and version, time zone setting and location, browser plug-in types and versions, operating system and platform, and other technology on the devices you use to access this website.</li>";
            $policy .= "<li><strong>Usage Data</strong> includes information about how you use our website, products, and services.</li>";
        }
        
        if ($collect_payments) {
            $policy .= "<li><strong>Financial Data</strong> includes payment information. However, we do not store full credit card numbers as all payment processing is handled by secure third-party payment processors.</li>";
        }
        
        $policy .= "</ul>";
    }
    
    if ($collect_cookies) {
        $policy .= "<h2>3. Cookies</h2>";
        $policy .= "<p>Our website uses cookies to distinguish you from other users of our website. This helps us to provide you with a good experience when you browse our website and also allows us to improve our site.</p>";
        $policy .= "<p>A cookie is a small file of letters and numbers that we store on your browser or the hard drive of your computer if you agree. Cookies contain information that is transferred to your computer's hard drive.</p>";
        $policy .= "<p>You can set your browser to refuse all or some browser cookies, or to alert you when websites set or access cookies. If you disable or refuse cookies, please note that some parts of this website may become inaccessible or not function properly.</p>";
    }
    
    $policy .= "<h2>4. How We Use Your Personal Data</h2>";
    $policy .= "<p>We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>";
    $policy .= "<ul>";
    $policy .= "<li>Where we need to perform the contract we are about to enter into or have entered into with you.</li>";
    $policy .= "<li>Where it is necessary for our legitimate interests (or those of a third party) and your interests and fundamental rights do not override those interests.</li>";
    $policy .= "<li>Where we need to comply with a legal obligation.</li>";
    
    if ($has_newsletter) {
        $policy .= "<li>With your consent, to send you our newsletter or marketing communications.</li>";
    }
    
    $policy .= "</ul>";
    
    if ($third_party_services) {
        $policy .= "<h2>5. Third-Party Services</h2>";
        $policy .= "<p>We may use third-party services on our website, such as:</p>";
        $policy .= "<ul>";
        
        if ($collect_analytics) {
            $policy .= "<li>Analytics providers (such as Google Analytics)</li>";
        }
        
        if ($collect_payments) {
            $policy .= "<li>Payment processors</li>";
        }
        
        $policy .= "<li>Hosting providers</li>";
        $policy .= "</ul>";
        $policy .= "<p>These third-party service providers may collect information about you when you visit our website. They have their own privacy policies regarding the information we are required to provide to them about your interactions with our website.</p>";
    }
    
    if ($share_data) {
        $policy .= "<h2>6. Disclosures of Your Personal Data</h2>";
        $policy .= "<p>We may share your personal data with the parties set out below for the purposes set out in this privacy policy:</p>";
        $policy .= "<ul>";
        $policy .= "<li>Service providers who provide IT and system administration services.</li>";
        $policy .= "<li>Professional advisers including lawyers, bankers, auditors, and insurers.</li>";
        $policy .= "<li>Regulators and other authorities who require reporting of processing activities in certain circumstances.</li>";
        $policy .= "<li>Third parties to whom we may choose to sell, transfer, or merge parts of our business or our assets.</li>";
        $policy .= "</ul>";
        $policy .= "<p>We require all third parties to respect the security of your personal data and to treat it in accordance with the law. We do not allow our third-party service providers to use your personal data for their own purposes and only permit them to process your personal data for specified purposes and in accordance with our instructions.</p>";
    }
    
    $policy .= "<h2>7. Data Security</h2>";
    $policy .= "<p>We have put in place appropriate security measures to prevent your personal data from being accidentally lost, used, or accessed in an unauthorized way, altered, or disclosed. In addition, we limit access to your personal data to those employees, agents, contractors, and other third parties who have a business need to know.</p>";
    
    $policy .= "<h2>8. Data Retention</h2>";
    $policy .= "<p>{$data_retention}</p>";
    
    if ($user_rights) {
        $policy .= "<h2>9. Your Legal Rights</h2>";
        $policy .= "<p>Under certain circumstances, you have rights under data protection laws in relation to your personal data:</p>";
        $policy .= "<ul>";
        $policy .= "<li><strong>Request access</strong> to your personal data.</li>";
        $policy .= "<li><strong>Request correction</strong> of your personal data.</li>";
        $policy .= "<li><strong>Request erasure</strong> of your personal data.</li>";
        $policy .= "<li><strong>Object to processing</strong> of your personal data.</li>";
        $policy .= "<li><strong>Request restriction of processing</strong> your personal data.</li>";
        $policy .= "<li><strong>Request transfer</strong> of your personal data.</li>";
        $policy .= "<li><strong>Right to withdraw consent.</strong></li>";
        $policy .= "</ul>";
        $policy .= "<p>If you wish to exercise any of the rights set out above, please contact us at {$contact_email}.</p>";
    }
    
    $policy .= "<h2>10. Changes to This Privacy Policy</h2>";
    $policy .= "<p>We may update our privacy policy from time to time. Any changes we make to our privacy policy in the future will be posted on this page and, where appropriate, notified to you by email. Please check back frequently to see any updates or changes to our privacy policy.</p>";
    
    $policy .= "<h2>11. Contact Us</h2>";
    $policy .= "<p>If you have any questions about this privacy policy or our privacy practices, please contact us at {$contact_email}.</p>";
    
    return $policy;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy Generator | Create GDPR & CCPA Compliant Policies</title>
    <meta name="description" content="Generate a professional privacy policy for your website in minutes. Our free tool creates GDPR and CCPA compliant privacy policies customized for your business needs.">
    <meta name="keywords" content="privacy policy generator, privacy policy template, GDPR privacy policy, CCPA privacy policy, website legal documents, free privacy policy">
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>
    
    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🔒</text></svg>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <!-- Custom CSS -->
    <style>
        :root {
    --primary-color: #4361ee;
    --secondary-color: #3f37c9;
    --accent-color: #4895ef;
    --text-color: #333;
    --light-gray: #f8f9fa;
    --border-radius: 10px;
}

body {
    font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    color: var(--text-color);
    line-height: 1.6;
    background-color: #fafafa;
}

.navbar {
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.navbar-brand {
    font-weight: 700;
    color: var(--primary-color);
}

.hero {
    background-color: var(--primary-color);
    color: white;
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.hero::after {
    content: "";
    position: absolute;
    bottom: -5rem;
    right: -5rem;
    width: 15rem;
    height: 15rem;
    background-color: var(--accent-color);
    border-radius: 50%;
    opacity: 0.3;
}

.hero::before {
    content: "";
    position: absolute;
    top: -3rem;
    left: -3rem;
    width: 10rem;
    height: 10rem;
    background-color: var(--secondary-color);
    border-radius: 50%;
    opacity: 0.2;
}

.hero-title {
    font-weight: 800;
    font-size: 2.8rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
}

.hero-subtitle {
    font-weight: 400;
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    position: relative;
    z-index: 2;
}

.card {
    border: none;
    background: none;
    box-shadow: none;
    transition: none;
}

.card:hover {
    transform: none;
    box-shadow: none;
}

.card-header {
    background-color: white;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    font-weight: 600;
    font-size: 1.2rem;
    padding: 1.5rem;
    border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: var(--border-radius);
    padding: 0.75rem 1rem;
    border: 1px solid #dee2e6;
}

.form-control:focus, .form-select:focus {
    border-color: var(--accent-color);
    box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
}

.btn-primary:hover, .btn-primary:focus {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
}

.btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
}

.btn-outline-primary:hover, .btn-outline-primary:focus {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
}

.feature-card {
    text-align: center;
    padding: 2rem;
    height: 100%;
}

.feature-icon {
    width: 4rem;
    height: 4rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(67, 97, 238, 0.1);
    color: var(--primary-color);
    font-size: 1.5rem;
    border-radius: 50%;
    margin: 0 auto 1.5rem;
}

.feature-title {
    font-weight: 600;
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.policy-preview {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.policy-preview h1, .policy-preview h2 {
    color: var(--primary-color);
}

.policy-preview h1 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.policy-preview h2 {
    font-size: 1.5rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.policy-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

footer {
    background-color: var(--light-gray);
    padding: 3rem 0;
    margin-top: 5rem;
}

.footer-title {
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--primary-color);
}

.footer-link {
    color: var(--text-color);
    text-decoration: none;
    display: block;
    margin-bottom: 0.75rem;
    transition: color 0.3s ease;
}

.footer-link:hover {
    color: var(--primary-color);
}

.section-title {
    position: relative;
    display: inline-block;
    margin-bottom: 3rem;
    font-weight: 700;
}

.section-title::after {
    content: "";
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 50px;
    height: 3px;
    background-color: var(--primary-color);
}

@media (max-width: 768px) {
    .hero {
        padding: 3rem 0;
    }
    
    .hero-title {
        font-size: 2.2rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .policy-actions {
        flex-direction: column;
    }
}

.testimonial {
    text-align: center;
    padding: 2rem;
}

.testimonial-text {
    font-style: italic;
    position: relative;
    padding: 0 2rem;
}

.testimonial-text::before,
.testimonial-text::after {
    content: """;
    font-size: 4rem;
    line-height: 1;
    position: absolute;
    color: rgba(67, 97, 238, 0.1);
}

.testimonial-text::before {
    top: -1rem;
    left: 0;
}

.testimonial-text::after {
    content: """;
    bottom: -2rem;
    right: 0;
}

.testimonial-author {
    margin-top: 2rem;
    font-weight: 600;
}

.testimonial-company {
    font-size: 0.9rem;
    opacity: 0.7;
}

#copy-success {
    display: none;
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #4caf50;
    color: white;
    padding: 15px 25px;
    border-radius: var(--border-radius);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

.loading-spinner {
    display: none;
    margin-right: 10px;
}

/* Enhancements for better responsiveness */
@media (max-width: 992px) {
    .hero-title {
        font-size: 2.4rem;
    }
    
    .feature-card {
        margin-bottom: 2rem;
    }
}

@media (max-width: 768px) {
    .hero {
        padding: 3rem 0;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .policy-actions {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .card-header {
        padding: 1.25rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 1.8rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .card-header {
        padding: 1rem;
        font-size: 1.1rem;
    }
    
    .form-label {
        margin-bottom: 0.3rem;
    }
    
    .form-control, .form-select {
        padding: 0.6rem 0.8rem;
    }
    
    .btn-primary, .btn-outline-primary {
        padding: 0.6rem 1.2rem;
    }
    
    .policy-preview {
        padding: 1.25rem;
    }
    
    .policy-preview h1 {
        font-size: 1.5rem;
    }
    
    .policy-preview h2 {
        font-size: 1.2rem;
    }
    
    .accordion-button {
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }
    
    .testimonial {
        padding: 1.5rem 1rem;
    }
}

/* Additional responsive improvements */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.img-fluid {
    max-width: 100%;
    height: auto;
}

/* Improve form layout on smaller screens */
@media (max-width: 576px) {
    .row > [class*="col-"] {
        margin-bottom: 1rem;
    }
    
    /* Reset bottom margin for the last element in a row */
    .row > [class*="col-"]:last-child {
        margin-bottom: 0;
    }
}

/* Ensure proper spacing in the policy preview on mobile */
@media (max-width: 576px) {
    .policy-preview ul, .policy-preview ol {
        padding-left: 1.25rem;
    }
}

/* Better support for extra small screens */
@media (max-width: 375px) {
    html {
        font-size: 14px;
    }
    
    .container {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
}

    </style>
</head>
<body>
    <!-- Notification -->
    <div id="copy-success">
        <i class="bi bi-check-circle-fill me-2"></i> Privacy policy copied to clipboard!
    </div>


    <!-- Generator Section -->
    <section class="py-5 bg-light" id="generator">
        <div class="container">
            <h2 class="text-center section-title">Privacy Policy Generator - Infinitytoolspace</h2>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            Fill out the form to generate your privacy policy
                        </div>
                        <div class="card-body">
                        <form method="post" id="privacy-form">
                               <div class="row mb-4">
                                   <div class="col-md-6 mb-3">
                                       <label for="company_name" class="form-label">Company/Website Name*</label>
                                       <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $company_name; ?>" required>
                                   </div>
                                   <div class="col-md-6 mb-3">
                                       <label for="website_url" class="form-label">Website URL*</label>
                                       <input type="url" class="form-control" id="website_url" name="website_url" value="<?php echo $website_url; ?>" placeholder="https://example.com" required>
                                   </div>
                               </div>
                               
                               <div class="row mb-4">
                                   <div class="col-md-6 mb-3">
                                       <label for="contact_email" class="form-label">Contact Email*</label>
                                       <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo $contact_email; ?>" required>
                                   </div>
                                   <div class="col-md-6 mb-3">
                                       <label for="effective_date" class="form-label">Effective Date*</label>
                                       <input type="date" class="form-control" id="effective_date" name="effective_date" value="<?php echo $effective_date; ?>" required>
                                   </div>
                               </div>
                               
                               <h5 class="mb-3">Data Collection</h5>
                               <div class="row mb-4">
                                   <div class="col-md-6 mb-3">
                                       <div class="form-check">
                                           <input class="form-check-input" type="checkbox" id="collect_personal_info" name="collect_personal_info" <?php if($collect_personal_info) echo 'checked'; ?>>
                                           <label class="form-check-label" for="collect_personal_info">
                                               Collect personal information
                                           </label>
                                       </div>
                                   </div>
                                   <div class="col-md-6 mb-3">
                                       <div class="form-check">
                                           <input class="form-check-input" type="checkbox" id="collect_cookies" name="collect_cookies" <?php if($collect_cookies) echo 'checked'; ?>>
                                           <label class="form-check-label" for="collect_cookies">
                                               Use cookies
                                           </label>
                                       </div>
                                   </div>
                               </div>
                               
                               <div class="row mb-4">
                                   <div class="col-md-6 mb-3">
                                       <div class="form-check">
                                           <input class="form-check-input" type="checkbox" id="collect_analytics" name="collect_analytics" <?php if($collect_analytics) echo 'checked'; ?>>
                                           <label class="form-check-label" for="collect_analytics">
                                               Use analytics tools
                                           </label>
                                       </div>
                                   </div>
                                   <div class="col-md-6 mb-3">
                                       <div class="form-check">
                                           <input class="form-check-input" type="checkbox" id="collect_payments" name="collect_payments" <?php if($collect_payments) echo 'checked'; ?>>
                                           <label class="form-check-label" for="collect_payments">
                                               Process payments
                                           </label>
                                       </div>
                                   </div>
                               </div>
                               
                               <h5 class="mb-3">Website Features</h5>
                               <div class="row mb-4">
                                   <div class="col-md-4 mb-3">
                                       <div class="form-check">
                                           <input class="form-check-input" type="checkbox" id="has_newsletter" name="has_newsletter" <?php if($has_newsletter) echo 'checked'; ?>>
                                           <label class="form-check-label" for="has_newsletter">
                                               Newsletter subscription
                                           </label>
                                       </div>
                                   </div>
                                   <div class="col-md-4 mb-3">
                                       <div class="form-check">
                                           <input class="form-check-input" type="checkbox" id="has_account" name="has_account" <?php if($has_account) echo 'checked'; ?>>
                                           <label class="form-check-label" for="has_account">
                                               User accounts
                                           </label>
                                       </div>
                                   </div>
                                   <div class="col-md-4 mb-3">
                                       <div class="form-check">
                                           <input class="form-check-input" type="checkbox" id="has_comments" name="has_comments" <?php if($has_comments) echo 'checked'; ?>>
                                           <label class="form-check-label" for="has_comments">
                                               Comments section
                                           </label>
                                       </div>
                                   </div>
                               </div>
                               
                               <h5 class="mb-3">Third-Party Services & Data Sharing</h5>
                               <div class="row mb-4">
                                   <div class="col-md-6 mb-3">
                                       <div class="form-check">
                                           <input class="form-check-input" type="checkbox" id="third_party_services" name="third_party_services" <?php if($third_party_services) echo 'checked'; ?>>
                                           <label class="form-check-label" for="third_party_services">
                                               Use third-party services
                                           </label>
                                       </div>
                                   </div>
                                   <div class="col-md-6 mb-3">
                                       <div class="form-check">
                                           <input class="form-check-input" type="checkbox" id="share_data" name="share_data" <?php if($share_data) echo 'checked'; ?>>
                                           <label class="form-check-label" for="share_data">
                                               Share data with third parties
                                           </label>
                                       </div>
                                   </div>
                               </div>
                               
                               <div class="mb-4">
                                   <label for="data_retention" class="form-label">Data Retention Policy</label>
                                   <textarea class="form-control" id="data_retention" name="data_retention" rows="3"><?php echo $data_retention; ?></textarea>
                               </div>
                               
                               <div class="mb-4">
                                   <div class="form-check">
                                       <input class="form-check-input" type="checkbox" id="user_rights" name="user_rights" <?php if($user_rights) echo 'checked'; ?>>
                                       <label class="form-check-label" for="user_rights">
                                           Include user rights section (GDPR, CCPA)
                                       </label>
                                   </div>
                               </div>
                               
                               <div class="d-grid">
                                   <button type="submit" class="btn btn-primary" id="generate-btn">
                                       <span class="spinner-border spinner-border-sm loading-spinner" role="status" aria-hidden="true"></span>
                                       Generate Privacy Policy
                                   </button>
                               </div>
                           </form>
                           
                           <?php if (!empty($privacy_policy)): ?>
                               <div class="policy-preview mt-5" id="policy-preview">
                                   <?php echo $privacy_policy; ?>
                                   
                                   <div class="policy-actions">
                                       <button class="btn btn-primary" id="copy-btn">Copy HTML</button>
                                       <button class="btn btn-outline-primary" id="download-btn">Download as HTML</button>
                                       <button class="btn btn-outline-primary" id="print-btn">Print</button>
                                   </div>
                               </div>
                           <?php endif; ?>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </section>


   <!-- FAQ Section -->
   <section class="py-5 bg-light" id="faq">
       <div class="container">
           <h2 class="text-center section-title">Frequently Asked Questions</h2>
           <div class="row">
               <div class="col-lg-10 mx-auto">
                   <div class="accordion" id="faqAccordion">
                       <div class="accordion-item">
                           <h2 class="accordion-header" id="headingOne">
                               <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                   Why do I need a privacy policy?
                               </button>
                           </h2>
                           <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                               <div class="accordion-body">
                                   A privacy policy is legally required if you collect any personal information from your website visitors. Many privacy laws worldwide, including GDPR in Europe and CCPA in California, mandate that websites disclose how they collect, use, and protect personal data. Even if you only collect basic information like email addresses, having a privacy policy helps build trust with your users and protects you legally.
                               </div>
                           </div>
                       </div>
                       <div class="accordion-item">
                           <h2 class="accordion-header" id="headingTwo">
                               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                   Is the generated privacy policy legally compliant?
                               </button>
                           </h2>
                           <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                               <div class="accordion-body">
                                   Our privacy policy generator is designed to create policies that align with common legal requirements including GDPR and CCPA. However, we recommend having your privacy policy reviewed by a legal professional to ensure it meets all requirements specific to your business and jurisdiction. Legal requirements vary by location and business type, and laws are subject to change.
                               </div>
                           </div>
                       </div>
                       <div class="accordion-item">
                           <h2 class="accordion-header" id="headingThree">
                               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                   How do I add the privacy policy to my website?
                               </button>
                           </h2>
                           <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                               <div class="accordion-body">
                                   After generating your privacy policy, you can copy the HTML code and paste it into a new page on your website. Most website platforms like WordPress, Shopify, or Wix allow you to create a dedicated page for legal policies. We recommend linking to your privacy policy in your website footer so it's accessible from every page of your site.
                               </div>
                           </div>
                       </div>
                       <div class="accordion-item">
                           <h2 class="accordion-header" id="headingFour">
                               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                   How often should I update my privacy policy?
                               </button>
                           </h2>
                           <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                               <div class="accordion-body">
                                   You should update your privacy policy whenever you make significant changes to how you collect, use, or share personal data. This includes adding new features to your website, using new third-party services, or changing your data practices. It's also good practice to review your privacy policy at least once a year to ensure it remains current with evolving privacy laws and your business practices.
                               </div>
                           </div>
                       </div>
                       <div class="accordion-item">
                           <h2 class="accordion-header" id="headingFive">
                               <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                   Is this privacy policy generator completely free?
                               </button>
                           </h2>
                           <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                               <div class="accordion-body">
                                   Yes, our privacy policy generator is completely free to use with no hidden costs or subscription fees. You can generate, copy, and download your privacy policy at no charge. We believe in making privacy compliance accessible to everyone, from small businesses to large enterprises.
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </section>

   

   <!-- SEO Content (Hidden but accessible to search engines) -->
   <div class="container mt-5" style="display: none;">
       <h2>Generate Free Privacy Policy for Your Website</h2>
       <p>Our free privacy policy generator helps website owners, bloggers, and small businesses create comprehensive privacy policies that comply with global privacy laws including GDPR, CCPA, and more.</p>
       
       <h3>Why You Need a Privacy Policy</h3>
       <p>A privacy policy is a legal requirement for websites that collect personal information from users. It informs visitors about how their data is collected, used, disclosed, and managed by your website.</p>
       
       <h3>Key Components of a Good Privacy Policy</h3>
       <ul>
           <li>What personal information is collected</li>
           <li>How the information is collected</li>
           <li>Why the information is collected</li>
           <li>How the information is used</li>
           <li>How the information is stored and protected</li>
           <li>Whether the information is shared with third parties</li>
           <li>User rights regarding their personal information</li>
           <li>Cookie policy information</li>
           <li>Contact information for privacy-related questions</li>
       </ul>
       
       <h3>Privacy Laws Our Generator Addresses</h3>
       <ul>
           <li>General Data Protection Regulation (GDPR) - European Union</li>
           <li>California Consumer Privacy Act (CCPA) - California, USA</li>
           <li>Personal Information Protection and Electronic Documents Act (PIPEDA) - Canada</li>
           <li>Australia Privacy Act</li>
           <li>Other international privacy regulations</li>
       </ul>
       
       <h3>Privacy Policy Generator for All Types of Websites</h3>
       <p>Our privacy policy generator is suitable for various types of websites, including:</p>
       <ul>
           <li>E-commerce stores</li>
           <li>Blogs and content websites</li>
           <li>SaaS applications</li>
           <li>Mobile apps</li>
           <li>Portfolio websites</li>
           <li>Non-profit organizations</li>
           <li>Small business websites</li>
       </ul>
   </div>

   <!-- Bootstrap Bundle with Popper -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
   
   <!-- Bootstrap Icons -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
   
   <!-- Custom Script -->
   <script>
       document.addEventListener('DOMContentLoaded', function() {
           const copyBtn = document.getElementById('copy-btn');
           const downloadBtn = document.getElementById('download-btn');
           const printBtn = document.getElementById('print-btn');
           const policyPreview = document.getElementById('policy-preview');
           const copySuccess = document.getElementById('copy-success');
           const generateBtn = document.getElementById('generate-btn');
           const loadingSpinner = document.querySelector('.loading-spinner');
           
           // Initialize form validation
           const form = document.getElementById('privacy-form');
           if (form) {
               form.addEventListener('submit', function() {
                   // Show loading spinner during form submission
                   loadingSpinner.style.display = 'inline-block';
               });
           }
           
           // Copy HTML to clipboard
           if (copyBtn && policyPreview) {
               copyBtn.addEventListener('click', function() {
                   // Create a temporary textarea element
                   const textarea = document.createElement('textarea');
                   textarea.value = policyPreview.innerHTML;
                   document.body.appendChild(textarea);
                   
                   // Select and copy the content
                   textarea.select();
                   document.execCommand('copy');
                   
                   // Remove the textarea
                   document.body.removeChild(textarea);
                   
                   // Show success message
                   copySuccess.style.display = 'block';
                   setTimeout(function() {
                       copySuccess.style.display = 'none';
                   }, 3000);
               });
           }
           
           // Download HTML
           if (downloadBtn && policyPreview) {
               downloadBtn.addEventListener('click', function() {
                   const htmlContent = `
                       <!DOCTYPE html>
                       <html lang="en">
                       <head>
                           <meta charset="UTF-8">
                           <meta name="viewport" content="width=device-width, initial-scale=1.0">
                           <title>Privacy Policy</title>
                           <style>
                               body {
                                   font-family: Arial, sans-serif;
                                   line-height: 1.6;
                                   color: #333;
                                   max-width: 800px;
                                   margin: 0 auto;
                                   padding: 20px;
                               }
                               h1 {
                                   color: #4361ee;
                                   border-bottom: 2px solid #4361ee;
                                   padding-bottom: 10px;
                               }
                               h2 {
                                   color: #4361ee;
                                   margin-top: 30px;
                               }
                               p, ul {
                                   margin-bottom: 15px;
                               }
                               ul {
                                   padding-left: 20px;
                               }
                           </style>
                       </head>
                       <body>
                           ${policyPreview.innerHTML.split('<div class="policy-actions">')[0]}
                       </body>
                       </html>
                   `;
                   
                   const blob = new Blob([htmlContent], { type: 'text/html' });
                   const url = URL.createObjectURL(blob);
                   
                   const a = document.createElement('a');
                   a.href = url;
                   a.download = 'privacy-policy.html';
                   document.body.appendChild(a);
                   a.click();
                   
                   // Clean up
                   document.body.removeChild(a);
                   URL.revokeObjectURL(url);
               });
           }
           
           // Print Privacy Policy
           if (printBtn && policyPreview) {
               printBtn.addEventListener('click', function() {
                   const printContent = `
                       <!DOCTYPE html>
                       <html lang="en">
                       <head>
                           <meta charset="UTF-8">
                           <title>Privacy Policy</title>
                           <style>
                               body {
                                   font-family: Arial, sans-serif;
                                   line-height: 1.6;
                                   color: #333;
                                   max-width: 800px;
                                   margin: 0 auto;
                                   padding: 20px;
                               }
                               h1 {
                                   color: #4361ee;
                                   border-bottom: 2px solid #4361ee;
                                   padding-bottom: 10px;
                               }
                               h2 {
                                   color: #4361ee;
                                   margin-top: 30px;
                               }
                               p, ul {
                                   margin-bottom: 15px;
                               }
                               ul {
                                   padding-left: 20px;
                               }
                           </style>
                       </head>
                       <body>
                           ${policyPreview.innerHTML.split('<div class="policy-actions">')[0]}
                       </body>
                       </html>
                   `;
                   
                   const printWindow = window.open('', '_blank');
                   printWindow.document.write(printContent);
                   printWindow.document.close();
                   printWindow.focus();
                   
                   // Wait for content to load before printing
                   setTimeout(function() {
                       printWindow.print();
                       printWindow.close();
                   }, 250);
               });
           }
           
           // Smooth scrolling for anchor links
           const anchorLinks = document.querySelectorAll('a[href^="#"]');
           anchorLinks.forEach(link => {
               link.addEventListener('click', function(e) {
                   e.preventDefault();
                   
                   const targetId = this.getAttribute('href');
                   if (targetId === '#') return;
                   
                   const targetElement = document.querySelector(targetId);
                   if (targetElement) {
                       window.scrollTo({
                           top: targetElement.offsetTop - 70,
                           behavior: 'smooth'
                       });
                   }
               });
           });
       });
   </script>
</body>
</html>
<?php include("../footer.php")?>