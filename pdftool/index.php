<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDFPro - Premium PDF Tools</title>
    <meta name="description" content="Free online PDF tools to merge, split, compress, convert and edit PDF files. Fast, secure, and easy to use.">
    <meta name="keywords" content="pdf tools, pdf editor, pdf converter, online pdf, pdf merge, pdf split, pdf compress">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="PDFPro - Premium PDF Tools">
    <meta property="og:description" content="Free online PDF tools to merge, split, compress, convert and edit PDF files. Fast, secure, and easy to use.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://infinitytoolspace/tools/pdftool">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
    :root {
        --primary-color: #6a3de8;
        --primary-light: #8764e8;
        --primary-dark: #4a2cb4;
        --secondary-color: #f5f3ff;
        --text-color: #333;
        --light-gray: #f8f9fa;
        --white: #ffffff;
        --card-shadow: 0 10px 25px rgba(106, 61, 232, 0.08);
        --hover-shadow: 0 15px 30px rgba(106, 61, 232, 0.15);
    }
    
    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-color);
        background-color: var(--white);
    }
    
    .hero-section {
        padding: 120px 0;
        background: linear-gradient(135deg, #f5f3ff 0%, #e0d6ff 100%);
        text-align: center;
    }
    
    .hero-title {
        font-weight: 800;
        font-size: 3.2rem;
        margin-bottom: 20px;
        color: var(--text-color);
    }
    
    .tools-section {
        padding: 100px 0;
        background-color: var(--white);
    }
    
    .section-title {
        text-align: center;
        margin-bottom: 20px;
        font-weight: 700;
        font-size: 2.5rem;
        color: var(--primary-dark);
    }
    
    .section-subtitle {
        text-align: center;
        margin-bottom: 60px;
        font-weight: 400;
        font-size: 1.2rem;
        color: #666;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .tool-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        height: 100%;
        border: none;
        cursor: pointer;
        position: relative;
    }
    
    .tool-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--hover-shadow);
    }
    
    .tool-card::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(106, 61, 232, 0.05) 0%, rgba(106, 61, 232, 0.0) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 16px;
    }
    
    .tool-card:hover::after {
        opacity: 1;
    }
    
    .tool-icon {
        font-size: 2.8rem;
        margin-bottom: 20px;
        color: var(--primary-color);
        transition: transform 0.3s ease;
    }
    
    .tool-card:hover .tool-icon {
        transform: scale(1.1);
    }
    
    .tool-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 12px;
        color: var(--primary-dark);
    }
    
    .tool-description {
        color: #666;
        margin-bottom: 25px;
        line-height: 1.6;
    }
    
    .features-section {
        padding: 100px 0;
        background-color: var(--secondary-color);
    }
    
    .feature-item {
        text-align: center;
        padding: 30px 20px;
        margin-bottom: 30px;
        border-radius: 16px;
        background-color: var(--white);
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }
    
    .feature-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }
    
    .feature-icon {
        font-size: 3.2rem;
        color: var(--primary-color);
        margin-bottom: 25px;
    }
    
    .feature-title {
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 1.5rem;
        color: var(--primary-dark);
    }
    
    .feature-description {
        color: #666;
        line-height: 1.6;
    }
    
    footer {
        padding: 80px 0 30px;
        background-color: #2d1a69;
        color: #ecf0f1;
    }
    
    .footer-title {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 25px;
        color: var(--white);
    }
    
    .footer-title span {
        color: #b49df7;
    }
    
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-links li {
        margin-bottom: 12px;
    }
    
    .footer-links a {
        color: #b49df7;
        text-decoration: none;
        transition: color 0.3s;
        font-weight: 500;
    }
    
    .footer-links a:hover {
        color: var(--white);
    }
    
    .social-links {
        list-style: none;
        padding: 0;
        margin: 20px 0;
        display: flex;
    }
    
    .social-links li {
        margin-right: 18px;
    }
    
    .social-links a {
        color: #b49df7;
        font-size: 1.5rem;
        transition: all 0.3s;
    }
    
    .social-links a:hover {
        color: var(--white);
        transform: translateY(-3px);
    }
    
    .copyright {
        text-align: center;
        padding-top: 40px;
        margin-top: 40px;
        border-top: 1px solid #3d2a7d;
        color: #9a86c8;
        font-size: 0.95rem;
    }
    
    @media (max-width: 767px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
    }
</style>
</head>
<body>
    

    <!-- Tools Section -->
    <section id="tools" class="tools-section">
        <div class="container">
            <h2 class="section-title">Our PDF Tools</h2>
            <p class="section-subtitle">Discover our range of free, powerful tools designed to make your PDF workflow seamless and efficient.</p>
            
            <div class="row" id="tools-container">
                <!-- Tools will be dynamically loaded here from tools.json -->
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <h2 class="section-title">Why Choose PDFPro</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">100% Secure</h3>
                        <p class="feature-description">Your files are automatically deleted after processing. We never store your sensitive documents.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="feature-title">Lightning Fast</h3>
                        <p class="feature-description">Our optimized processing ensures your PDFs are ready in seconds, saving you valuable time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h3 class="feature-title">Works Everywhere</h3>
                        <p class="feature-description">Access our tools from any device with a browser. No software installation required.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-cloud-download-alt"></i>
                        </div>
                        <h3 class="feature-title">Free to Use</h3>
                        <p class="feature-description">All our basic tools are completely free with no hidden costs or registration required.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3 class="feature-title">Advanced Features</h3>
                        <p class="feature-description">Professional-grade tools with intuitive interfaces designed for both beginners and experts.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">24/7 Support</h3>
                        <p class="feature-description">Our friendly support team is always ready to assist you with any questions or issues.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Footer -->
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Function to load tools from JSON file
        function loadTools() {
    fetch('tools.json')
        .then(response => response.json())
        .then(data => {
            const toolsContainer = document.getElementById('tools-container');
            toolsContainer.innerHTML = '';
            
            data.tools.forEach(tool => {
                const toolCard = `
                    <div class="col-md-4 col-lg-3 mb-4">
                        <a href="${tool.url}" style="text-decoration: none; color: inherit;">
                            <div class="card tool-card">
                                <div class="card-body text-center">
                                    <div class="tool-icon">
                                        <i class="${tool.icon}"></i>
                                    </div>
                                    <h3 class="tool-title">${tool.name}</h3>
                                    <p class="tool-description">${tool.description}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
                toolsContainer.innerHTML += toolCard;
            });
        })
        .catch(error => {
            console.error('Error loading tools:', error);
            document.getElementById('tools-container').innerHTML = `
                <div class="col-12 text-center">
                    <p>Failed to load tools. Please try again later.</p>
                </div>
            `;
        });
}
        
        // Load tools when the page is ready
        document.addEventListener('DOMContentLoaded', loadTools);
    </script>
    
</body>
</html>