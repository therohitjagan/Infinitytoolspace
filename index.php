<?php
// Load tools from JSON file
$toolsJsonFile = 'tools.json';
$tools = [];

if (file_exists($toolsJsonFile)) {
    $toolsJson = file_get_contents($toolsJsonFile);
    $tools = json_decode($toolsJson, true);
}

// Get current tool if selected
$currentTool = null;
$toolId = isset($_GET['tool']) ? $_GET['tool'] : null;

if ($toolId !== null && isset($tools[$toolId])) {
    $currentTool = $tools[$toolId];
    // Only allow loading tools with a path (internal tools)
    if (!isset($currentTool['path'])) {
        // If it's an external tool, redirect to its URL
        if (isset($currentTool['url'])) {
            header("Location: " . $currentTool['url']);
            exit;
        }
        // If neither path nor URL is set, show an error or redirect home
        header("Location: index");
        exit;
    }
}

$banners = [
    [
        'image_url' => 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg5dKQejjaAHOApxJQtCFSYDIW2R3fC1v7DtQwoBKbf1hDQbiN3n9Y7GrQjV2g-nq2fhUBKmuLv1CPvB0CR4w5_a_d-1S-nUEpd2wA0uFBmQJ6NrJdtEEjZ-ptnJsGuZVeHmfl5vARuKIx2tvauFLUzF7F_N0Rjs4dql0IQXZ-ewc_-ZjVyd34fFdjGRQAl/s16000/a6021b6e-d93f-44c5-a90b-7d919531dffc.png',
        'alt_text' => 'WinCash Games',
        'link' => 'https://wincash.co.in/'
    ]
    // Add more banners as needed
];

// Get random banner (or use a specific one)
$currentBanner = $banners[array_rand($banners)];

// Search functionality
// $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
// $searchResults = [];

// if (!empty($searchQuery)) {
//     foreach ($tools as $id => $tool) {
//         // Search in title, description, and keywords
//         if (
//             stripos($tool['title'], $searchQuery) !== false || 
//             stripos($tool['short_description'], $searchQuery) !== false || 
//             stripos($tool['description'], $searchQuery) !== false || 
//             stripos($tool['keywords'], $searchQuery) !== false
//         ) {
//             $searchResults[$id] = $tool;
//         }
//     }
// }

// Website configuration
$siteConfig = [
    'title' => 'InfinityToolSpace - Free Online Tools for Everyone',
    'description' => 'Boost your productivity with InfinityToolSpace — a free online tools hub for PDF editing, image conversion, SEO analysis, calculators, text utilities, and more. No sign-up needed!',
    'keywords' => 'free online tools, web utilities, PDF tools, image converters, text utilities, online calculators, SEO tools, InfinityToolSpace,free online tools, web utilities, PDF editor, image converter, text tools, online calculators, SEO analyzer, InfinityToolSpace, productivity tools, browser-based tools',
    'author' => 'Infinitytoolspace',
    'logo' => 'assets/logo.png',
    'favicon' => 'assets/favicon.ico',
    'themeColor' => '#3498db'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $currentTool ? $currentTool['title'] . ' - ' . $siteConfig['title'] : $siteConfig['title']; ?></title>
    <meta name="description" content="<?php echo $currentTool ? $currentTool['description'] : $siteConfig['description']; ?>">
    <meta name="keywords" content="<?php echo $siteConfig['keywords']; ?><?php echo $currentTool ? ', ' . $currentTool['keywords'] : ''; ?>">
    <meta name="author" content="<?php echo $siteConfig['author']; ?>">
    <meta name="theme-color" content="<?php echo $siteConfig['themeColor']; ?>">
    
    <link rel="canonical" href="https://infinitytoolspace.com/" />

    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "InfinityToolSpace",
  "url": "https://infinitytoolspace.com/",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://infinitytoolspace.com/search?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>


<meta property="og:title" content="InfinityToolSpace - Free Online Tools & Utilities">
<meta property="og:description" content="Explore InfinityToolSpace — a powerful suite of free online tools for your everyday needs.">
<meta property="og:image" content="https://infinitytoolspace.com/assets/logo.png">
<meta property="og:url" content="https://infinitytoolspace.com/">
<meta name="twitter:card" content="summary_large_image">

   <meta name="yandex-verification" content="95509701096aac46" /> 
    
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $siteConfig['favicon']; ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom CSS - Dark Glassmorphism Theme */
:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    --accent-color: #ec4899;
    --dark-bg: #151823;
    --card-bg: rgba(30, 34, 45, 0.7);
    --text-color: #e2e8f0;
    --text-muted: #94a3b8;
    --border-color: rgba(255, 255, 255, 0.08);
    --glass-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    --card-radius: 16px;
    --transition: all 0.3s ease;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    background-color: var(--dark-bg);
    color: var(--text-color);
    line-height: 1.6;
}

/* Glassmorphism Navbar */
.navbar {
    background-color: rgba(25, 28, 38, 0.8) !important;
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-bottom: 1px solid var(--border-color);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    padding: 15px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.navbar-brand {
    font-weight: 800;
    color: var(--primary-color) !important;
    letter-spacing: -0.5px;
}

.nav-link {
    font-weight: 500;
    color: var(--text-color) !important;
    margin: 0 10px;
    transition: var(--transition);
}

.nav-link:hover {
    color: var(--primary-color) !important;
}

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid var(--border-color);
    color: white;
    padding: 6rem 0;
    margin-bottom: 3rem;
    border-radius: 0 0 30px 30px;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: linear-gradient(to right, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.2));
    top: -150px;
    right: -50px;
    filter: blur(30px);
}

.hero-section::after {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: linear-gradient(to right, rgba(139, 92, 246, 0.2), rgba(236, 72, 153, 0.2));
    bottom: -100px;
    left: 10%;
    filter: blur(30px);
}

.hero-title {
    font-weight: 800;
    font-size: 3rem;
    margin-bottom: 1rem;
    letter-spacing: -1px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.hero-subtitle {
    font-weight: 400;
    font-size: 1.25rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.hero-search {
    background: rgba(30, 34, 45, 0.7);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid var(--border-color);
    border-radius: 50px;
    padding: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.hero-search .form-control {
    background: rgba(255, 255, 255, 0.05);
    border: none;
    box-shadow: none;
    padding-left: 20px;
    border-radius: 50px;
    color: var(--text-color);
}

.hero-search .form-control::placeholder {
    color: var(--text-muted);
}

.hero-search .btn {
    border-radius: 50px;
    padding: 8px 25px;
    font-weight: 600;
}

/* Card Styling */
.tool-card {
    background: var(--card-bg);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid var(--border-color);
    transition: var(--transition);
    height: 100%;
    border-radius: var(--card-radius);
    overflow: hidden;
    box-shadow: var(--glass-shadow);
}

.tool-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.tool-card .card-img-top {
    height: 200px;
    object-fit: cover;
    border-bottom: 1px solid var(--border-color);
}

.tool-card .card-body {
    padding: 1.5rem;
}

.tool-card .card-title {
    color: var(--text-color);
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
}

.tool-card .card-text {
    color: var(--text-muted);
    margin-bottom: 1.25rem;
}

/* Button Styling */
.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border: none;
    border-radius: 50px;
    padding: 8px 20px;
    font-weight: 600;
    transition: var(--transition);
    box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.5);
}

.btn-light {
    background: rgba(255, 255, 255, 0.08);
    color: var(--text-color);
    border: 1px solid var(--border-color);
    border-radius: 50px;
    padding: 8px 20px;
    font-weight: 600;
    transition: var(--transition);
}

.btn-light:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Tool Container */
.tool-container {
    background: var(--card-bg);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid var(--border-color);
    border-radius: var(--card-radius);
    box-shadow: var(--glass-shadow);
    padding: 2.5rem;
    margin-bottom: 2.5rem;
}

/* Navbar Toggle */
.navbar-toggler {
    border: none;
    padding: 0.5rem;
    transition: var(--transition);
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
}

.navbar-toggler:focus {
    box-shadow: none;
    outline: none;
}

.navbar-toggler i {
    font-size: 1.5rem;
    color: var(--primary-color);
}

/* Tool Header */
.tool-header {
    margin-bottom: 2rem;
}

.tool-header h1 {
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-color);
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.tool-description {
    color: var(--text-muted);
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

/* Section Title */
.section-title {
    position: relative;
    display: inline-block;
    margin-bottom: 1.5rem;
    font-weight: 700;
    color: var(--text-color);
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 50px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    border-radius: 2px;
}

/* Footer */
.footer {
    background: rgba(25, 28, 38, 0.9);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-top: 1px solid var(--border-color);
    color: var(--text-color);
    padding: 4rem 0 2rem;
    margin-top: 5rem;
    border-radius: 30px 30px 0 0;
    box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.2);
}

.footer h5 {
    font-weight: 700;
    margin-bottom: 1.5rem;
    position: relative;
    display: inline-block;
}

.footer h5::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 30px;
    height: 3px;
    background: var(--accent-color);
    border-radius: 2px;
}

.footer-links {
    list-style: none;
    padding: 0;
}

.footer-links li {
    margin-bottom: 0.75rem;
}

.footer-links a {
    color: var(--text-muted);
    text-decoration: none;
    transition: var(--transition);
}

.footer-links a:hover {
    color: var(--text-color);
    padding-left: 5px;
}

/* Social Links */
.social-links {
    margin-top: 1.5rem;
}

.social-links a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    color: var(--text-color);
    margin-right: 0.75rem;
    font-size: 1rem;
    transition: var(--transition);
    border: 1px solid var(--border-color);
}

.social-links a:hover {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
    border-color: transparent;
}

/* Support Info */
.support-info {
    margin-top: 1.5rem;
}

.support-info p {
    margin-bottom: 0.5rem;
    color: var(--text-muted);
}

.support-info i {
    width: 20px;
    color: var(--accent-color);
}

.copyright {
    font-size: 0.9rem;
    color: var(--text-muted);
}

/* Cookie Banner */
.cookie-banner {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 1200px;
    background: rgba(30, 34, 45, 0.85);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    color: var(--text-color);
    text-align: center;
    padding: 20px;
    display: none;
    z-index: 9999;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    border-radius: 16px;
    border: 1px solid var(--border-color);
}

.cookie-banner p {
    color: var(--text-muted);
    margin-bottom: 15px;
}

.cookie-banner button {
    background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
    color: white;
    border: none;
    padding: 12px 25px;
    margin: 0 10px;
    cursor: pointer;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
}

.cookie-banner button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(99, 102, 241, 0.4);
}

.cookie-banner a {
    color: var(--primary-color);
    text-decoration: underline;
}

/* Cookie Management Section */
.cookie-management {
    background: rgba(30, 34, 45, 0.7);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
    border: 1px solid var(--border-color);
}

.cookie-management h3 {
    color: var(--primary-color);
    margin-bottom: 15px;
}

.browser-links a {
    display: inline-block;
    margin: 5px 10px 5px 0;
    padding: 8px 15px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 5px;
    transition: all 0.3s ease;
    color: var(--text-muted);
    text-decoration: none;
    border: 1px solid var(--border-color);
}

.browser-links a:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-color);
}

/* Banner Styling */
.banner-container {
    margin: 2rem auto 3rem;
    overflow: hidden;
    border-radius: var(--card-radius);
    box-shadow: var(--glass-shadow);
    position: relative;
    max-width: 1200px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid var(--border-color);
}

.banner-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    border-color: rgba(255, 255, 255, 0.15);
}

.banner-link {
    display: block;
    text-decoration: none;
    color: inherit;
}

.banner-image {
    width: 100%;
    height: auto;
    display: block;
    max-height: 200px;
    object-fit: cover;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .hero-section {
        padding: 4rem 0;
        border-radius: 0 0 20px 20px;
    }
    
    .hero-title {
        font-size: 2.2rem;
    }
    
    .footer {
        border-radius: 20px 20px 0 0;
        padding: 3rem 0 1.5rem;
    }
    
    .banner-image {
        max-height: 300px;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-search {
        flex-direction: column;
    }
    
    .hero-search .btn {
        margin-top: 10px;
        width: 100%;
    }
    
    .cookie-banner {
        bottom: 10px;
        padding: 15px;
    }
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: rgba(30, 34, 45, 0.5);
}

::-webkit-scrollbar-thumb {
    background: rgba(99, 102, 241, 0.5);
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(99, 102, 241, 0.7);
}

/* Input Fields */
input, textarea, select {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid var(--border-color) !important;
    color: var(--text-color) !important;
}

input::placeholder, textarea::placeholder {
    color: var(--text-muted) !important;
}

/* Focus handling */
a:focus, button:focus, input:focus, textarea:focus, select:focus {
    outline: 2px solid var(--primary-color) !important;
    outline-offset: 2px !important;
}

/* Update Popup Styling */
.update-popup {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 380px;
    max-width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    background: rgba(30, 34, 45, 0.95);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid var(--border-color);
    border-radius: var(--card-radius);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    z-index: 9999;
    padding: 0;
    color: var(--text-color);
    transition: all 0.3s ease;
    transform: translateY(120%);
    opacity: 0;
}

.update-popup.show {
    transform: translateY(0);
    opacity: 1;
}

.update-popup-header {
    padding: 15px 20px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius: var(--card-radius) var(--card-radius) 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.update-popup-header h3 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 700;
    color: white;
}

.update-popup-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    color: white;
}

.update-popup-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

.update-popup-content {
    padding: 20px;
}

.update-popup-version {
    margin-bottom: 15px;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 15px;
}

.update-popup-version h4 {
    font-weight: 700;
    margin-bottom: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.update-badge {
    background: var(--accent-color);
    color: white;
    font-size: 0.75rem;
    padding: 3px 8px;
    border-radius: 15px;
    font-weight: 600;
}

.update-date {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-bottom: 10px;
}

.update-description {
    margin-bottom: 15px;
    color: var(--text-muted);
}

.update-changes {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
}

.update-changes li {
    position: relative;
    padding-left: 20px;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.update-changes li:before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--accent-color);
    font-weight: bold;
}

.update-popup-footer {
    padding: 15px 20px;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
}

.update-popup-footer button {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid var(--border-color);
    color: var(--text-color);
    padding: 8px 15px;
    border-radius: 20px;
    cursor: pointer;
    transition: var(--transition);
    font-size: 0.9rem;
}

.update-popup-footer button.primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border: none;
    box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
}

.update-popup-footer button:hover {
    transform: translateY(-2px);
}

.update-dot {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 12px;
    height: 12px;
    background-color: var(--accent-color);
    border-radius: 50%;
    box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.3);
    cursor: pointer;
    z-index: 9998;
    animation: pulse 2s infinite;
    display: none;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(236, 72, 153, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(236, 72, 153, 0);
    }
}
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="index">
                <?php if(file_exists($siteConfig['logo'])): ?>
                <img src="<?php echo $siteConfig['logo']; ?>" alt="InfinityToolSpace" height="30" class="me-2">
                <?php endif; ?>
                InfinityToolSpace
            </a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa-solid fa-bars"></i>
</button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tools">Tools</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pdftool/">PDF Tools</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us">Contact</a>
                    </li>
                </ul>
                <!-- <form class="d-flex" action="index.php" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search tools..." aria-label="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form> -->
            </div>
        </div>
    </nav>

    <?php if($currentTool === null): ?>


        <!-- <?php if(!empty($searchQuery)): ?>
        <div class="container py-5">
            <h2 class="mb-4">Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
            
            <?php if(empty($searchResults)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> No tools found matching your search. Try different keywords.
            </div>
            <div class="mt-3">
                <a href="index.php" class="btn btn-primary">View All Tools</a>
            </div>
            <?php else: ?>
            <p class="mb-4">Found <?php echo count($searchResults); ?> tool<?php echo count($searchResults) > 1 ? 's' : ''; ?> matching your query.</p>
            
            <div class="row g-4">
                <?php foreach($searchResults as $id => $tool): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card tool-card"> -->


    <img src="<?php echo htmlspecialchars($tool['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($tool['title']); ?>">
    <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($tool['title']); ?></h5>
        <p class="card-text"><?php echo htmlspecialchars($tool['short_description']); ?></p>
        <?php if(isset($tool['path'])): ?>
            <a href="?tool=<?php echo $id; ?>" class="btn btn-primary">Use Tool</a>
        <?php elseif(isset($tool['url'])): ?>
            <a href="<?php echo htmlspecialchars($tool['url']); ?>" class="btn btn-primary" >Visit Tool</a>
        <?php endif; ?>
    </div>
  <!-- </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-4">
                <a href="index.php" class="btn btn-outline-secondary">Clear Search</a>
            </div>
            <?php endif; ?>
        </div>
        <?php else: ?> -->
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container text-center">
                <h1 class="hero-title">Powerful Tools for Everyday Tasks</h1>
                <p class="hero-subtitle">Free online utilities to make your life easier</p>
                <div class="row justify-content-center">
                    <!-- <div class="col-md-6">
                         <form class="d-flex" action="index.php" method="GET">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search for tools..." aria-label="Search">
                            <button class="btn btn-light" type="submit">Search</button>
                        </form> 
                    </div> -->
                </div>
                <div class="mt-3">
                    <a href="#tools" class="btn btn-light btn-lg">Explore All Tools</a>
                </div>
            </div>
        </section>
        
       
        
        <!-- Tools Section -->
        <section id="tools" class="py-5">
            <div class="container">
                <h2 class="text-center mb-4">Our Tools</h2>
                <p class="text-center mb-5">Discover our collection of free online tools designed to simplify your daily tasks</p>
                
                <div class="row g-4">
                    <?php foreach($tools as $id => $tool): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card tool-card">
    <img src="<?php echo htmlspecialchars($tool['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($tool['title']); ?>">
    <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($tool['title']); ?></h5>
        <p class="card-text"><?php echo htmlspecialchars($tool['short_description']); ?></p>
        <?php if(isset($tool['path'])): ?>
            <a href="?tool=<?php echo $id; ?>" class="btn btn-primary">Use Tool</a>
        <?php elseif(isset($tool['url'])): ?>
            <a href="<?php echo htmlspecialchars($tool['url']); ?>" class="btn btn-primary" >Visit Tool</a>
        <?php endif; ?>
    </div>
</div>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if(empty($tools)): ?>
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> No tools available yet. Check back soon!
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        
        
        <!-- Add this after the hero section and before the tools section -->

        
        <!-- About and Contact sections remain unchanged -->
    
    <?php else: ?>
    <!-- Tool Specific Page -->
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#tools">Tools</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($currentTool['title']); ?></li>
            </ol>
        </nav>
        
        <div class="tool-container">
            <div class="tool-header">
                <h1><?php echo htmlspecialchars($currentTool['title']); ?></h1>
                <p class="tool-description"><?php echo htmlspecialchars($currentTool['description']); ?></p>
            </div>
            
            <div class="tool-content mb-4">
                <?php if(isset($currentTool['path']) && file_exists($currentTool['path'])): ?>
                    <?php include($currentTool['path']); ?>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i> Tool content not available.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Related Tools -->
        <?php if(!empty($tools)): ?>
        <div class="related-tools">
            <h3 class="mb-3">Other Tools You Might Like</h3>
            <div class="row g-4">
                <?php 
                $count = 0;
                foreach($tools as $id => $tool): 
                    if($id !== $toolId && $count < 3): 
                    $count++;
                ?>
                <div class="col-md-4">
<div class="card tool-card">
    <img src="<?php echo htmlspecialchars($tool['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($tool['title']); ?>">
    <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($tool['title']); ?></h5>
        <p class="card-text"><?php echo htmlspecialchars($tool['short_description']); ?></p>
        <?php if(isset($tool['path'])): ?>
            <a href="?tool=<?php echo $id; ?>" class="btn btn-primary">Use Tool</a>
        <?php elseif(isset($tool['url'])): ?>
            <a href="<?php echo htmlspecialchars($tool['url']); ?>" class="btn btn-primary" >Visit Tool</a>
        <?php endif; ?>
    </div>
</div>
                </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <!-- Simplified clickable banner -->
<?php if(isset($currentBanner)): ?>
<section class="container">
    <div class="banner-container">
        <a href="<?php echo htmlspecialchars($currentBanner['link']); ?>" class="banner-link">
            <img src="<?php echo htmlspecialchars($currentBanner['image_url']); ?>" 
                 alt="<?php echo htmlspecialchars($currentBanner['alt_text']); ?>" 
                 class="banner-image img-fluid">
        </a>
    </div>
</section>
<?php endif; ?>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5><?php echo $siteConfig['title']; ?></h5>
                    <p>Free online tools and utilities to make your daily tasks easier and more efficient.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/Infinitytoolspace"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="index">Home</a></li>
                        <li><a href="#tools">Tools</a></li>
                        <li><a href="about">About</a></li>
                        <li><a href="contact-us">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5>Categories</h5>
                    <ul class="footer-links support-info">
                <li></li><i class="fas fa-envelope"></i> <a href="mailto:contact@Infinitytoolspace.com">contact@Infinitytoolspace.com</a></li>
                <p><i class="fas fa-map-marker-alt"></i>Ghaziabad, Uttar Pradesh, India</p>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h5>Legal</h5>
                    <ul class="footer-links">
                        <li><a href="privacy">Privacy Policy</a></li>
                        <li><a href="terms">Terms of Service</a></li>
                        <li><a href="cookie">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo $siteConfig['title']; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <div class="cookie-banner" id="cookieBanner">
    <p>This website uses cookies to enhance user experience. By using this site, you agree to our <a href="cookie.php" style="color: #ffdd57;">Cookie Policy</a>.</p>
    <button onclick="acceptCookies()">Accept</button>
</div>
    
    <!-- Footer remains unchanged -->
    
    <!-- JavaScript remains mostly unchanged, but we'll add search-related functionality -->
    <script>
        // Contact form validation
        (function() {
            'use strict';
            
            // Fetch all forms with class 'needs-validation'
            var forms = document.querySelectorAll('.needs-validation');
            
            // Loop over forms and prevent submission
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        event.preventDefault();
                        // Simulate form submission
                        const submitBtn = form.querySelector('button[type="submit"]');
                        const originalText = submitBtn.innerHTML;
                        
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';
                        
                        setTimeout(function() {
                            form.reset();
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                            
                            // Show success message
                            const successAlert = document.createElement('div');
                            successAlert.className = 'alert alert-success mt-3';
                            successAlert.role = 'alert';
                            successAlert.innerHTML = '<i class="fas fa-check-circle me-2"></i> Your message has been sent successfully!';
                            
                            form.parentNode.appendChild(successAlert);
                            
                            // Remove success message after 5 seconds
                            setTimeout(function() {
                                successAlert.remove();
                            }, 5000);
                        }, 1500);
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
        })();
        
        // Tool-specific JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            <?php if($currentTool !== null && isset($currentTool['tool_js'])): ?>
                <?php echo $currentTool['tool_js']; ?>
            <?php endif; ?>
        });
        
        function acceptCookies() {
    document.cookie = "cookieConsent=true; path=/; max-age=" + (60 * 60 * 24 * 365);
    document.getElementById("cookieBanner").style.display = "none";
}
if (!document.cookie.includes("cookieConsent=true")) {
    document.getElementById("cookieBanner").style.display = "block";
}
    </script>
    
    <!-- SEO Structured Data -->
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "InfinityToolSpace",
  "url": "https://infinitytoolspace.com/",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://infinitytoolspace.com/search?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
<script>// Update popup functionality
document.addEventListener('DOMContentLoaded', function() {
    const updatePopup = document.getElementById('updatePopup');
    const updateContent = document.getElementById('updateContent');
    const closeUpdateBtn = document.getElementById('closeUpdateBtn');
    const dismissUpdateBtn = document.getElementById('dismissUpdateBtn');
    const acknowledgeUpdateBtn = document.getElementById('acknowledgeUpdateBtn');
    const updateDot = document.getElementById('update-dot');
    
    // Check if user has acknowledged the latest update
    function checkForUpdates() {
        fetch('updates.json?v=' + new Date().getTime())
            .then(response => response.json())
            .then(data => {
                const lastAcknowledgedVersion = localStorage.getItem('acknowledgedVersion') || '0.0.0';
                
                // Compare versions
                if (compareVersions(data.currentVersion, lastAcknowledgedVersion) > 0) {
                    // Show update notification dot
                    updateDot.style.display = 'block';
                    
                    // Populate update content
                    updateContent.innerHTML = '';
                    
                    data.updates.sort((a, b) => compareVersions(b.version, a.version)).forEach(update => {
                        if (compareVersions(update.version, lastAcknowledgedVersion) > 0) {
                            const versionElement = document.createElement('div');
                            versionElement.className = 'update-popup-version';
                            
                            const titleHTML = `
                                <h4>
                                    ${update.title}
                                    <span class="update-badge">v${update.version}</span>
                                </h4>
                                <div class="update-date">${formatDate(update.date)}</div>
                                <div class="update-description">${update.description}</div>
                            `;
                            
                            const changesHTML = `
                                <ul class="update-changes">
                                    ${update.changes.map(change => `<li>${change}</li>`).join('')}
                                </ul>
                            `;
                            
                            versionElement.innerHTML = titleHTML + changesHTML;
                            updateContent.appendChild(versionElement);
                        }
                    });
                    
                    // If update dot is clicked, show popup
                    updateDot.addEventListener('click', showUpdatePopup);
                    
                    // Automatically show update popup for critical updates or after a delay
                    const hasCriticalUpdate = data.updates.some(update => 
                        update.critical && compareVersions(update.version, lastAcknowledgedVersion) > 0
                    );
                    
                    if (hasCriticalUpdate) {
                        showUpdatePopup();
                    } else {
                        // For non-critical updates, show after user has spent some time on the site
                        setTimeout(() => {
                            // Only show if user hasn't dismissed it recently
                            const lastDismissed = localStorage.getItem('updateDismissedTime');
                            const now = new Date().getTime();
                            
                            if (!lastDismissed || (now - parseInt(lastDismissed)) > 24 * 60 * 60 * 1000) {
                                showUpdatePopup();
                            }
                        }, 30000); // Show after 30 seconds
                    }
                }
            })
            .catch(error => console.error('Error loading updates:', error));
    }
    
    function showUpdatePopup() {
        updatePopup.classList.add('show');
    }
    
    function hideUpdatePopup() {
        updatePopup.classList.remove('show');
    }
    
    // Format date as "Month Day, Year"
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
    }
    
    // Compare two version strings
    function compareVersions(v1, v2) {
        const parts1 = v1.split('.').map(Number);
        const parts2 = v2.split('.').map(Number);
        
        for (let i = 0; i < 3; i++) {
            const part1 = parts1[i] || 0;
            const part2 = parts2[i] || 0;
            
            if (part1 > part2) return 1;
            if (part1 < part2) return -1;
        }
        
        return 0;
    }
    
    // Event listeners
    closeUpdateBtn.addEventListener('click', hideUpdatePopup);
    
    dismissUpdateBtn.addEventListener('click', function() {
        // Save dismiss time
        localStorage.setItem('updateDismissedTime', new Date().getTime());
        hideUpdatePopup();
    });
    
    acknowledgeUpdateBtn.addEventListener('click', function() {
        // Save acknowledged version
        fetch('updates.json?v=' + new Date().getTime())
            .then(response => response.json())
            .then(data => {
                localStorage.setItem('acknowledgedVersion', data.currentVersion);
                updateDot.style.display = 'none';
                hideUpdatePopup();
            })
            .catch(error => console.error('Error:', error));
    });
    
    // Check for updates when page loads
    checkForUpdates();
});
</script>

<!-- Update Notification Dot -->
<div class="update-dot" id="update-dot"></div>

<!-- Update Popup -->
<div class="update-popup" id="updatePopup">
    <div class="update-popup-header">
        <h3><i class="fas fa-sync-alt me-2"></i> What's New</h3>
        <button class="update-popup-close" id="closeUpdateBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="update-popup-content" id="updateContent">
        <!-- Update versions will be dynamically loaded here -->
    </div>
    <div class="update-popup-footer">
        <button id="dismissUpdateBtn">Dismiss</button>
        <button class="primary" id="acknowledgeUpdateBtn">Got it!</button>
    </div>
</div>


</body>
</html>