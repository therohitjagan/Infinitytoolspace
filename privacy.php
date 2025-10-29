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
    <meta name="title" content="Privacy Policy - InfinityToolSpace">
    <meta name="description" content="Read the Privacy Policy of InfinityToolSpace. Learn how we collect, use, and protect your personal information while using our web tools.">
    <meta name="keywords" content="privacy policy, InfinityToolSpace, data protection, user information, cookies policy">
    <meta name="author" content="InfinityToolSpace">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $site_url ?>/privacy">

    <!-- Open Graph (For social media sharing) -->
    <meta property="og:title" content="Privacy Policy - InfinityToolSpace">
    <meta property="og:description" content="Read how InfinityToolSpace collects, stores, and protects your personal data.">
    <meta property="og:url" content="<?= $site_url ?>/privacy">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Privacy Policy - InfinityToolSpace">
    <meta name="twitter:description" content="Read how InfinityToolSpace collects, stores, and protects your personal data.">

    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>

    <!-- Favicon -->
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
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

    <title>Privacy Policy - InfinityToolSpace</title>

    <!-- JSON-LD Structured Data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Privacy Policy - InfinityToolSpace",
        "description": "Read the Privacy Policy of InfinityToolSpace. Learn how we collect, use, and protect your personal information while using our web tools.",
        "url": "<?= $site_url ?>/privacy.php",
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
    <h1 class="text-center">Privacy Policy</h1>
    <p>Last Updated: <strong><?= $last_updated ?></strong></p>
    
    <h2>1. Introduction</h2>
    <p>Welcome to <strong><?= $site_name ?></strong> (<?= $site_url ?>). We value your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data.</p>

    <h2>2. Information We Collect</h2>
    <p>We collect the following types of information:</p>
    <ul>
        <li>Personal Information: Name, email (only when you contact us).</li>
        <li>Non-Personal Information: Browser type, IP address, device type.</li>
        <li>Cookies: To improve user experience and analyze website performance.</li>
    </ul>

    <h2>3. How We Use Your Information</h2>
    <p>We use the collected data to:</p>
    <ul>
        <li>Improve website functionality and user experience.</li>
        <li>Analyze traffic and performance using Google Analytics.</li>
        <li>Respond to user inquiries and feedback.</li>
    </ul>

    <h2>4. Cookies Policy</h2>
    <p>We use cookies to store user preferences and enhance website performance. You can manage or disable cookies in your browser settings.</p>

    <h2>5. Third-Party Services</h2>
    <p>We use third-party tools such as Google Analytics for website analytics. These services may collect data under their own privacy policies.</p>

    <h2>6. Data Security</h2>
    <p>We take security seriously and implement strong security measures to protect your data. However, we cannot guarantee complete security due to the nature of the internet.</p>

    <h2>7. Your Rights</h2>
    <p>You have the right to:</p>
    <ul>
        <li>Request access to your personal data.</li>
        <li>Request deletion of your personal data.</li>
        <li>Opt-out of data collection through browser settings.</li>
    </ul>

    <h2>8. Updates to this Privacy Policy</h2>
    <p>We may update this policy from time to time. We will notify users of any significant changes by updating the date at the top of this page.</p>

    <h2>9. Contact Us</h2>
    <p>If you have any questions about this Privacy Policy, please contact us at: <a href="mailto:<?= $contact_email ?>"><?= $contact_email ?></a>.</p>

    <div class="text-center">
        <a href="<?= $site_url ?>" class="btn-back">Back to Home</a>
    </div>
</div>

<div class="footer">
    <p>&copy; <?= date("Y"); ?> <?= $site_name ?>. All Rights Reserved.</p>
</div>

</body>
</html>
