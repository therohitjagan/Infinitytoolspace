<!-- Main content ends here -->

<?php

$siteConfig = [
    'title' => 'Infinitytoolspace',
    'description' => 'Free online tools and utilities for everyday tasks',
    'keywords' => 'online tools, web utilities, free tools, online utilities',
    'author' => 'Infinitytoolspace',
    'logo' => 'assets/logo.png',
    'favicon' => 'assets/favicon.ico',
    'themeColor' => '#3498db'
];?>
    <head>
    <!-- Other head elements -->
    <link rel="stylesheet" href="../assets/style.css">
</head>
    
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5><?php echo $siteConfig['title']; ?></h5>
                    <p>Free online tools and utilities to make your daily tasks easier and more efficient.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="../index">Home</a></li>
                        <li><a href="../index#tools">Tools</a></li>
                        <li><a href="../about">About</a></li>
                        <li><a href="../contact-us">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="support-info">
                        <h5>Contact us</h5>
                        <p><i class="fas fa-envelope"></i> contact@infinitytoolspace.com</p>
                        <p><i class="fas fa-map-marker-alt"></i> Ghaziabad, Uttar Pradesh, India</p>
                        <!--<p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>-->
                    </div>
                </div>
                <div class="col-md-2">
                    <h5>Legal</h5>
                    <ul class="footer-links">
                        <li><a href="https://infinitytoolspace.com/privacy">Privacy Policy</a></li>
                        <li><a href="https://infinitytoolspace.com/terms">Terms of Service</a></li>
                        <li><a href="https://infinitytoolspace.com/cookie">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo $siteConfig['title']; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <?php if(isset($additionalJS)): echo $additionalJS; endif; ?>
    
    <!-- SEO Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?php echo $siteConfig['title']; ?>",
        "description": "<?php echo $siteConfig['description']; ?>",
        "url": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"
    }
    </script>
</body>
</html>