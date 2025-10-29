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
    <meta name="title" content="Cookie Policy - InfinityToolSpace">
    <meta name="description" content="Learn how InfinityToolSpace uses cookies to improve user experience, track analytics, and provide personalized content.">
    <meta name="keywords" content="cookie policy, cookies, InfinityToolSpace, data privacy, GDPR, user tracking">
    <meta name="author" content="InfinityToolSpace">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $site_url ?>/cookie">

    <!-- Open Graph (Social Media) -->
    <meta property="og:title" content="Cookie Policy - InfinityToolSpace">
    <meta property="og:description" content="Find out how we use cookies for analytics and user experience improvement.">
    <meta property="og:url" content="<?= $site_url ?>/cookie">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?= $site_url ?>/assets/cookie-banner.jpg">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Cookie Policy - InfinityToolSpace">
    <meta name="twitter:description" content="Find out how we use cookies for analytics and user experience improvement.">
    <meta name="twitter:image" content="<?= $site_url ?>/assets/cookie-banner.jpg">

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
        /* Cookie Consent Banner */
        /* Improved Cookie Consent Banner */
.cookie-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: rgba(44, 62, 80, 0.95);
    color: white;
    text-align: center;
    padding: 20px;
    display: none;
    z-index: 9999;
    box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(5px);
}

.cookie-banner p {
    color: #ecf0f1;
    margin-bottom: 15px;
}

.cookie-banner button {
    background: linear-gradient(45deg, #2ecc71, #27ae60);
    color: white;
    border: none;
    padding: 12px 25px;
    margin: 0 10px;
    cursor: pointer;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);
}

.cookie-banner button:hover {
    background: linear-gradient(45deg, #27ae60, #2ecc71);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(46, 204, 113, 0.4);
}

.cookie-banner a {
    color: #3498db;
    text-decoration: underline;
}

/* Cookie management section */
.cookie-management {
    background-color: #f1f8ff;
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
    border: 1px solid #d1e6ff;
}

.cookie-management h3 {
    color: #3498db;
    margin-bottom: 15px;
}

.browser-links a {
    display: inline-block;
    margin: 5px 10px 5px 0;
    padding: 8px 15px;
    background-color: #e9f5ff;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.browser-links a:hover {
    background-color: #d1e6ff;
}
    </style>

    <title>Cookie Policy - InfinityToolSpace</title>

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "Cookie Policy - InfinityToolSpace",
        "description": "Learn how InfinityToolSpace uses cookies to improve user experience, track analytics, and provide personalized content.",
        "url": "<?= $site_url ?>/cookie",
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
    <h1 class="text-center">Cookie Policy</h1>
    <p>Last Updated: <strong><?= $last_updated ?></strong></p>
    
    <h2>1. What Are Cookies?</h2>
    <p>Cookies are small files stored on your device that help improve user experience by remembering preferences and analyzing website performance.</p>

    <h2>2. How We Use Cookies</h2>
    <p>We use cookies to:</p>
    <ul>
        <li>Improve website functionality and speed.</li>
        <li>Analyze traffic using Google Analytics.</li>
        <li>Provide personalized content and advertisements.</li>
    </ul>

    <h2>3. Types of Cookies We Use</h2>
    <ul>
        <li><strong>Essential Cookies:</strong> Required for website functionality.</li>
        <li><strong>Analytical Cookies:</strong> Help analyze website traffic and user behavior.</li>
        <li><strong>Marketing Cookies:</strong> Used for personalized ads and promotions.</li>
    </ul>

    <h2>4. Managing Cookies</h2>
    <p>You can control or delete cookies via your browser settings:</p>
    <ul>
        <li>Google Chrome: <a href="https://support.google.com/chrome/answer/95647" target="_blank">Manage Cookies</a></li>
        <li>Mozilla Firefox: <a href="https://support.mozilla.org/en-US/kb/clear-cookies-and-site-data-firefox" target="_blank">Manage Cookies</a></li>
        <li>Safari: <a href="https://support.apple.com/en-us/HT201265" target="_blank">Manage Cookies</a></li>
    </ul>

    <h2>5. Contact Us</h2>
    <p>If you have any questions, contact us at <a href="mailto:<?= $contact_email ?>"><?= $contact_email ?></a>.</p>

    <div class="text-center">
        <a href="<?= $site_url ?>" class="btn-back">Back to Home</a>
    </div>
</div>

<div class="footer">
    <p>&copy; <?= date("Y"); ?> <?= $site_name ?>. All Rights Reserved.</p>
</div>

<!-- Cookie Consent Banner -->
<div class="cookie-banner" id="cookieBanner">
    <p>This website uses cookies to enhance user experience. By using this site, you agree to our <a href="cookie" style="color: #ffdd57;">Cookie Policy</a>.</p>
    <button onclick="acceptCookies()">Accept</button>
</div>

<script>
function acceptCookies() {
    document.cookie = "cookieConsent=true; path=/; max-age=" + (60 * 60 * 24 * 365);
    document.getElementById("cookieBanner").style.display = "none";
}
if (!document.cookie.includes("cookieConsent=true")) {
    document.getElementById("cookieBanner").style.display = "block";
}
</script>

</body>
</html>
