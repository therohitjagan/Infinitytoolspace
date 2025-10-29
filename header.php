<?php
// Website configuration
$siteConfig = [
    'title' => 'InfinityToolSpace',
    'description' => 'Free online tools and utilities for everyday tasks',
    'keywords' => 'online tools, web utilities, free tools, online utilities',
    'author' => 'InfinityToolSpace',
    'logo' => 'assets/logo.png',
    'favicon' => 'favicon.ico',
    'themeColor' => '#3498db'
];

// Get current page for active nav highlighting
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . $siteConfig['title'] : $siteConfig['title']; ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : $siteConfig['description']; ?>">
    <meta name="keywords" content="<?php echo $siteConfig['keywords']; ?><?php echo isset($pageKeywords) ? ', ' . $pageKeywords : ''; ?>">
    <meta name="author" content="<?php echo $siteConfig['author']; ?>">
    <meta name="theme-color" content="<?php echo $siteConfig['themeColor']; ?>">
    
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom CSS - updated for a more modern look */
:root {
    --primary-color: #4361ee;
    --secondary-color: #3a0ca3;
    --accent-color: #f72585;
    --light-color: #f8f9fa;
    --dark-color: #2b2d42;
    --text-color: #2b2d42;
    --text-light: #6c757d;
    --box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    --card-radius: 16px;
    --transition: all 0.3s ease;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    background-color: #f8f9fa;
    color: var(--text-color);
    line-height: 1.6;
}

.navbar {
    padding: 15px 0;
    background-color: rgba(255, 255, 255, 0.98) !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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

.hero-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
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
    background: rgba(255, 255, 255, 0.1);
    top: -150px;
    right: -50px;
}

.hero-section::after {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    bottom: -100px;
    left: 10%;
}

.hero-title {
    font-weight: 800;
    font-size: 3rem;
    margin-bottom: 1rem;
    letter-spacing: -1px;
}

.hero-subtitle {
    font-weight: 400;
    font-size: 1.25rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.navbar-toggler {
    border: none;
    padding: 0.5rem;
    transition: var(--transition);
}

.navbar-toggler:focus {
    box-shadow: none;
    outline: none;
}

.navbar-toggler i {
    font-size: 1.5rem;
    color: var(--primary-color);
}

.tool-card {
    transition: var(--transition);
    height: 100%;
    border-radius: var(--card-radius);
    overflow: hidden;
    border: none;
    box-shadow: var(--box-shadow);
}

.tool-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.tool-card .card-img-top {
    height: 200px;
    object-fit: cover;
}

.tool-card .card-body {
    padding: 1.5rem;
}

.tool-card .card-title {
    color: var(--dark-color);
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
}

.tool-card .card-text {
    color: var(--text-light);
    margin-bottom: 1.25rem;
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    border-radius: 50px;
    padding: 8px 20px;
    font-weight: 600;
    transition: var(--transition);
}

.btn-primary:hover {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
}

.btn-light {
    border-radius: 50px;
    padding: 8px 20px;
    font-weight: 600;
    transition: var(--transition);
}

.btn-light:hover {
    background-color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.tool-container {
    background-color: white;
    border-radius: var(--card-radius);
    box-shadow: var(--box-shadow);
    padding: 2.5rem;
    margin-bottom: 2.5rem;
}

.tool-header {
    margin-bottom: 2rem;
}

.tool-header h1 {
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--dark-color);
}

.tool-description {
    color: var(--text-light);
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.section-title {
    position: relative;
    display: inline-block;
    margin-bottom: 1.5rem;
    font-weight: 700;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 50px;
    height: 4px;
    background: var(--primary-color);
    border-radius: 2px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-section {
        padding: 4rem 0;
        border-radius: 0 0 20px 20px;
    }
    
    .hero-title {
        font-size: 2.2rem;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 1.8rem;
    }
}
    </style>
    
    <?php if(isset($additionalCSS)): echo $additionalCSS; endif; ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="index">
                <?php if(file_exists($siteConfig['logo'])): ?>
                <img src="<?php echo $siteConfig['logo']; ?>" alt="<?php echo $siteConfig['title']; ?>" height="30" class="me-2">
                <?php endif; ?>
                <?php echo $siteConfig['title']; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'index' ? 'active' : ''; ?>" href="../index">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'tools' ? 'active' : ''; ?>" href="../index#tools">Tools</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'about' ? 'active' : ''; ?>" href="../about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'contact-us' ? 'active' : ''; ?>" href="../contact-us">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main content starts here -->