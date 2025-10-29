<?php
// Website details
$site_name = "InfinityToolSpace";
$site_url = "https://infinitytoolspace.com";
$contact_email = "contact@infinitytoolspace.com";
$last_updated = date('F d, Y'); // Dynamic last updated date
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Terms & Conditions - InfinityToolSpace">
    <meta name="description" content="Read the Terms & Conditions of using InfinityToolSpace. Learn about your rights, responsibilities, and limitations while using our web tools.">
    <meta name="keywords" content="terms and conditions, InfinityToolSpace, website policy, legal agreement, usage policy">
    <meta name="author" content="InfinityToolSpace">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $site_url ?>/terms">

    <!-- Open Graph (For social media sharing) -->
    <meta property="og:title" content="Terms & Conditions - InfinityToolSpace">
    <meta property="og:description" content="Read the legal terms and conditions of using InfinityToolSpace.">
    <meta property="og:url" content="<?= $site_url ?>/terms">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?= $site_url ?>/assets/terms-banner.jpg">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Terms & Conditions - InfinityToolSpace">
    <meta name="twitter:description" content="Read the legal terms and conditions of using InfinityToolSpace.">
    <meta name="twitter:image" content="<?= $site_url ?>/assets/terms-banner.jpg">

    <!-- Favicon -->
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>
    
    <!-- Custom CSS -->
    <style>
        body {
    font-family: 'Poppins', 'Arial', sans-serif;
    background-color: #f8f9fa;
    color: #333;
    line-height: 1.6;
}

.container {
    max-width: 900px;
    margin: 40px auto;
    padding: 40px;
    background: white;
    border-radius: 12px;
    box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
}

.container:hover {
    transform: translateY(-5px);
}

h1 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 30px;
    position: relative;
    padding-bottom: 15px;
}

h1:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #007bff, #00c6ff);
    border-radius: 2px;
}

h2 {
    color: #3498db;
    font-weight: 600;
    margin-top: 30px;
    margin-bottom: 15px;
    border-left: 4px solid #3498db;
    padding-left: 15px;
}

p {
    font-size: 16px;
    line-height: 1.8;
    color: #555;
    margin-bottom: 20px;
}

ul li {
    margin-bottom: 10px;
    color: #555;
}

.footer {
    text-align: center;
    margin-top: 50px;
    padding: 20px;
    font-size: 14px;
    color: #777;
    border-top: 1px solid #eee;
}

.btn-back {
    margin-top: 30px;
    display: inline-block;
    text-decoration: none;
    background: linear-gradient(45deg, #007bff, #00c6ff);
    color: white;
    padding: 12px 25px;
    border-radius: 50px;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: linear-gradient(45deg, #0056b3, #007bff);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
    color: white;
    text-decoration: none;
}

a {
    color: #3498db;
    transition: color 0.3s ease;
}

a:hover {
    color: #2980b9;
    text-decoration: none;
}

/* Last updated info styling */
.last-updated {
    background-color: #f8f9fa;
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 25px;
    font-size: 14px;
    border-left: 4px solid #6c757d;
}

/* Add some animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.container {
    animation: fadeIn 0.5s ease-out;
}
    </style>

    <title>Terms & Conditions - InfinityToolSpace</title>

    <!-- JSON-LD Structured Data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Terms & Conditions - InfinityToolSpace",
        "description": "Read the Terms and Conditions of using InfinityToolSpace. Learn about your rights, responsibilities, and limitations while using our web tools.",
        "url": "<?= $site_url ?>/terms",
        "datePublished": "2025-03-14",
        "dateModified": "<?= date('Y-m-d'); ?>",
        "publisher": {
            "@type": "Organization",
            "name": "InfinityToolSpace",
            "url": "<?= $site_url ?>",
            "logo": "<?= $site_url ?>/assets/logo.png"
        }
    }
    </script>

</head>
<body>

<div class="container">
    <h1 class="text-center">Terms & Conditions</h1>
    <p>Last Updated: <strong><?= $last_updated ?></strong></p>
    
    <h2>1. Introduction</h2>
    <p>Welcome to <strong><?= $site_name ?></strong> (<?= $site_url ?>). By accessing and using this website, you agree to comply with our Terms & Conditions. If you do not agree, please do not use our services.</p>

    <h2>2. Acceptance of Terms</h2>
    <p>By using our services, you confirm that you have read, understood, and accepted these Terms. We reserve the right to update these terms at any time without prior notice.</p>

    <h2>3. User Responsibilities</h2>
    <p>As a user of <strong><?= $site_name ?></strong>, you agree to:</p>
    <ul>
        <li>Use the tools provided for lawful purposes only.</li>
        <li>Not engage in activities that harm the website or its users.</li>
        <li>Respect copyright and intellectual property rights.</li>
    </ul>

    <h2>4. Limitation of Liability</h2>
    <p>We strive to provide accurate and up-to-date tools, but we do not guarantee the accuracy or reliability of our services. <strong><?= $site_name ?></strong> is not responsible for any direct or indirect damages resulting from the use of our tools.</p>

    <h2>5. Privacy Policy</h2>
    <p>Your privacy is important to us. Please review our <a href="privacy.php">Privacy Policy</a> to understand how we collect, use, and protect your information.</p>

    <h2>6. Modifications to Terms</h2>
    <p>We reserve the right to modify these Terms at any time. Continued use of our services after modifications implies acceptance of the updated terms.</p>

    <h2>7. Contact Us</h2>
    <p>If you have any questions about these Terms, please contact us at: <a href="mailto:<?= $contact_email ?>"><?= $contact_email ?></a>.</p>

    <div class="text-center">
        <a href="<?= $site_url ?>" class="btn-back">Back to Home</a>
    </div>
</div>

<div class="footer">
    <p>&copy; <?= date("Y"); ?> <?= $site_name ?>. All Rights Reserved.</p>
</div>

</body>
</html>