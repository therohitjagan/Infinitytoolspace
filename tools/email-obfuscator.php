<?php
// Email Obfuscator Tool
$page_title = "Secure Email Obfuscator - Protect Emails from Spambots";
$meta_description = "Free online email obfuscator tool that converts email addresses into spam-bot proof formats using advanced encoding techniques. Protect your email privacy with our secure solution.";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    // Fix for deprecated FILTER_SANITIZE_STRING
    $subject = filter_input(INPUT_POST, 'subject', FILTER_UNSAFE_RAW);
    $subject = htmlspecialchars($subject ?? '', ENT_QUOTES, 'UTF-8');
    
    $body = filter_input(INPUT_POST, 'body', FILTER_UNSAFE_RAW);
    $body = htmlspecialchars($body ?? '', ENT_QUOTES, 'UTF-8');
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Multiple obfuscation methods
        $encoded_email = '&#'.implode(';&#', array_map('ord', str_split($email)));
        $rot13_email = str_rot13($email);
        $js_email = base64_encode($email);
        
        $mailto_js = "
        <script>
        function showMail() {
            var user = '".str_rot13(str_replace(['@','.'], ['#','|'], $email))."';
            var decoded = user.replace(/[#|]/g, m => ({'#':'@','|':'.'}[m])).split('').map(c=>c.charCodeAt(0)>=97&&c.charCodeAt(0)<=122?String.fromCharCode((c.charCodeAt(0)-97+13)%26+97):c.charCodeAt(0)>=65&&c.charCodeAt(0)<=90?String.fromCharCode((c.charCodeAt(0)-65+13)%26+65):c).join('');
            window.location.href = 'mailto:' + decoded + '?subject=".urlencode($subject)."&body=".urlencode($body)."';
        }
        </script>";
        
        // CSS Display Method
        $css_method = "<span class='obfuscated-email' data-name='".implode(',', array_map('ord', str_split(strstr($email, '@', true))))."' data-domain='".implode(',', array_map('ord', str_split(substr(strstr($email, '@'), 1))))."'></span>";
        
        // Image Method (text to SVG)
        $svg_email = '<svg xmlns="http://www.w3.org/2000/svg" width="'.strlen($email)*10.5.'" height="20">';
        for ($i = 0; $i < strlen($email); $i++) {
            $svg_email .= '<text x="'.($i*10).'" y="15" font-family="Arial" font-size="14" fill="#555">'.htmlspecialchars($email[$i]).'</text>';
        }
        $svg_email .= '</svg>';
        
        $result_html = "<div class='result-group'>
            <h4>Obfuscated Email Codes:</h4>
            
            <div class='result-item' data-type='html'>
                <label>HTML Entity Encoding:</label>
                <div class='code-container'>
                    <code class='d-block p-3 bg-light rounded'>$encoded_email</code>
                    <button class='copy-btn btn-sm' data-code='$encoded_email'><i class='bi bi-clipboard'></i></button>
                </div>
            </div>
            
            <div class='result-item' data-type='javascript'>
                <label>ROT13 JavaScript Version:</label>
                <div class='code-container'>
                    <code class='d-block p-3 bg-light rounded'>$rot13_email</code>
                    <button class='copy-btn btn-sm' data-code='$rot13_email'><i class='bi bi-clipboard'></i></button>
                </div>
            </div>
            
            <div class='result-item' data-type='svg'>
                <label>SVG Image Method:</label>
                <div class='code-container'>
                    <code class='d-block p-3 bg-light rounded'>".htmlspecialchars($svg_email)."</code>
                    <button class='copy-btn btn-sm' data-code='".htmlspecialchars($svg_email)."'><i class='bi bi-clipboard'></i></button>
                </div>
            </div>
            
            <div class='result-item' data-type='css'>
                <label>CSS Display Method:</label>
                <div class='code-container'>
                    <code class='d-block p-3 bg-light rounded'>".htmlspecialchars($css_method)."</code>
                    <button class='copy-btn btn-sm' data-code='".htmlspecialchars($css_method)."'><i class='bi bi-clipboard'></i></button>
                </div>
            </div>
            
            <div class='result-item' data-type='mailto'>
                <label>Interactive Mailto Link:</label>
                <div class='code-container'>
                    <pre class='p-3 bg-light rounded'><xmp><a href=\"javascript:void(0);\" onclick=\"showMail()\">Contact Us</a>$mailto_js</xmp></pre>
                    <button class='copy-btn btn-sm' data-code='<a href=\"javascript:void(0);\" onclick=\"showMail()\">Contact Us</a>$mailto_js'><i class='bi bi-clipboard'></i></button>
                </div>
            </div>
        </div>";
    } else {
        $error = "Invalid email address format!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="description" content="<?= $meta_description ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="keywords" content="email obfuscator, hide email from bots, protect email, spam protection tool, email encoding, email security tool, html email obfuscator, email encryptor">
<link rel="canonical" href="https://infinitytoolspace.com/tools/email-obfuscator" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <meta property="og:title" content="Email Obfuscator - Protect Emails from Spam Bots" />
<meta property="og:description" content="Encode your email into safe HTML to block spambots. Use our free online email obfuscator to keep your address secure." />
<meta property="og:url" content="https://infinitytoolspace.com/tools/email-obfuscator" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg9EqDkw46_g25sLV1PZo4WGzuzPAmHcFucXU8T51ikbYwCJ3F-fS2lhox_RMD8FsTo-Tz-HCRcx63FwCvv48cuKiQpp5PG5m_xK7rFwuBqKP7WPlzl1nz3UMN3ZgxXte_RHcdSl_LNTbyZRb9XvYWKH-TrcL12sDLuymVGTc-GbtRIXjF-6AMdB1g8P-w/s16000/Email%20Obfuscator.jpg" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #7209b7;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #2ec4b6;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            min-height: 100vh;
            background: #f8f9fa;
            background-image: 
                radial-gradient(#4361ee15 1px, transparent 1px),
                radial-gradient(#4361ee15 1px, transparent 1px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
            font-family: 'Poppins', sans-serif;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                rgba(255,255,255,0.05),
                rgba(255,255,255,0.05) 10px,
                transparent 10px,
                transparent 20px
            );
            animation: animate-bg 20s linear infinite;
        }
        
        @keyframes animate-bg {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .main-container {
            max-width: 900px;
            position: relative;
        }
        
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: var(--transition);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .form-control, .btn {
            border-radius: var(--border-radius);
            padding: 0.75rem 1.25rem;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
            border-color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: var(--transition);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .result-group {
            background: white;
        }
        
        .result-item {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .result-item label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .code-container {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        
        code, pre {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            border-radius: var(--border-radius);
            position: relative;
            background-color: #f8f9fa !important;
            transition: var(--transition);
        }
        
        .copy-btn {
            position: absolute;
            right: 10px;
            top: 10px;
            background-color: rgba(255,255,255,0.7);
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .copy-btn:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .preview-box {
            border: 2px dashed #dee2e6;
            border-radius: var(--border-radius);
            transition: var(--transition);
            background-color: #f8f9fd;
        }
        
        .preview-box:hover {
            border-color: var(--primary-color);
        }
        
        .method-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .method-tab {
            padding: 8px 16px;
            border-radius: 20px;
            background: #e9ecef;
            cursor: pointer;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        
        .method-tab:hover, .method-tab.active {
            background: var(--primary-color);
            color: white;
        }
        
        .theme-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000;
            box-shadow: var(--box-shadow);
            border: none;
            transition: var(--transition);
        }
        
        .theme-toggle:hover {
            transform: scale(1.1);
        }
        
        .dark-mode {
            background: #121212;
            color: #f8f9fa;
        }
        
        .dark-mode .card, .dark-mode .result-group {
            background: #1e1e1e;
            color: #f8f9fa;
        }
        
        .dark-mode .form-control, .dark-mode code, .dark-mode pre {
            background-color: #2d2d2d !important;
            border-color: #444;
            color: #f8f9fa;
        }
        
        .dark-mode .preview-box {
            background-color: #2d2d2d;
            border-color: #444;
        }
        
        .dark-mode .method-tab {
            background: #2d2d2d;
            color: #f8f9fa;
        }
        
        .obfuscated-email::before {
            content: attr(data-name);
        }
        
        .obfuscated-email::after {
            content: attr(data-domain);
        }
        
        footer {
            background: var(--dark-color);
        }
        
        .benefit-card {
            border-radius: var(--border-radius);
            padding: 1.5rem;
            height: 100%;
            transition: var(--transition);
            border-left: 4px solid var(--primary-color);
        }
        
        .benefit-card:hover {
            transform: translateY(-5px);
        }
        
        .dark-mode .benefit-card {
            background: #2d2d2d;
        }
        
        @media (max-width: 768px) {
            .display-4 {
                font-size: 2rem;
            }
            .benefit-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
    <header class="header py-5 mb-5">
        <div class="container position-relative">
            <h1 class="display-4 text-center fw-bold">Secure Email Obfuscator</h1>
            <p class="lead text-center">Protect your email addresses from spambots and harvesters</p>
        </div>
    </header>

    <main class="container main-container mb-5">
        <form method="post" class="card shadow mb-4">
            <div class="card-body p-4">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" required placeholder="Enter your email" 
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium">Email Subject (Optional)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-chat-square-text"></i></span>
                            <input type="text" name="subject" class="form-control" placeholder="Subject for mailto links"
                                   value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium">Email Body (Optional)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                            <input type="text" name="body" class="form-control" placeholder="Pre-filled email body" 
                                   value="<?= htmlspecialchars($_POST['body'] ?? '') ?>">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-shield-lock me-2"></i>Generate Secure Email
                </button>
            </div>
        </form>

        <?php if(isset($result_html)): ?>
        <div class="card shadow mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">Obfuscation Results</h4>
                    <button onclick="copyAll()" class="btn btn-outline-primary">
                        <i class="bi bi-clipboard me-2"></i>Copy All
                    </button>
                </div>
                
                <div class="method-tabs">
                    <div class="method-tab active" data-target="all">All Methods</div>
                    <div class="method-tab" data-target="html">HTML</div>
                    <div class="method-tab" data-target="javascript">JavaScript</div>
                    <div class="method-tab" data-target="css">CSS</div>
                    <div class="method-tab" data-target="svg">SVG</div>
                    <div class="method-tab" data-target="mailto">Mailto</div>
                </div>
                
                <?= $result_html ?>
                
                <div class="preview-box p-4 text-center mt-4">
                    <h5>Live Preview:</h5>
                    <p class="text-muted mb-3">Click the button below to see how the obfuscated email functions</p>
                    <a href="javascript:void(0);" onclick="showMail()" class="btn btn-outline-primary">
                        <i class="bi bi-envelope me-2"></i>Contact Us
                    </a>
                    <?= $mailto_js ?? '' ?>
                    
                    <div class="mt-3">
                        <p class="mb-0 text-muted">CSS Method Demo:</p>
                        <div id="css-demo"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow">
            <div class="card-body p-4">
                <h4 class="mb-4">How To Use These Codes</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="benefit-card bg-light h-100">
                            <h5><i class="bi bi-code-slash me-2"></i>HTML Method</h5>
                            <p class="mb-0">Insert the HTML entities directly into your webpage's HTML. This converts each character to its numerical HTML entity, making it harder for bots to recognize.</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="benefit-card bg-light h-100">
                            <h5><i class="bi bi-filetype-js me-2"></i>JavaScript Method</h5>
                            <p class="mb-0">Use this to dynamically reveal the email address only when a human interacts with the page, keeping it hidden from automated scanners.</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="benefit-card bg-light h-100">
                            <h5><i class="bi bi-filetype-css me-2"></i>CSS Method</h5>
                            <p class="mb-0">Implement with the related CSS to display the email. This method uses CSS attributes to reconstruct the email address.</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="benefit-card bg-light h-100">
                            <h5><i class="bi bi-image me-2"></i>SVG Method</h5>
                            <p class="mb-0">Renders the email as a vector image, making it readable to humans but difficult for bots to parse as text.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <footer class="text-white mt-auto py-4">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <h5><i class="bi bi-shield-check me-2"></i>Protection Benefits</h5>
                    <p>Our tool uses multiple encoding techniques to safeguard your contact information from spam bots and phishing attempts while maintaining accessibility for real users.</p>
                </div>
                <div class="col-md-4">
                    <h5><i class="bi bi-graph-up me-2"></i>SEO Benefits</h5>
                    <p>Safely include contact information on your website without worrying about spam crawlers. This helps maintain your domain reputation and SEO performance.</p>
                </div>
                <div class="col-md-4">
                    <h5><i class="bi bi-info-circle me-2"></i>How It Works</h5>
                    <p>We transform your email into various obfuscated formats that are difficult for automated bots to detect but remain functional for human visitors.</p>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="mb-0">&copy; <?= date('Y') ?> InfinityToolSpace. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!--<button class="theme-toggle" id="theme-toggle">-->
    <!--    <i class="bi bi-moon-stars-fill"></i>-->
    <!--</button>-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Copy functions
    function copyAll() {
        const codes = document.querySelectorAll('code, pre');
        let text = '';
        codes.forEach(code => {
            text += code.textContent + '\n\n';
        });
        copyToClipboard(text, 'All codes copied to clipboard!');
    }
    
    function copyToClipboard(text, message) {
        navigator.clipboard.writeText(text).then(() => {
            showToast(message);
        });
    }
    
    // Add individual copy buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Set up copy buttons
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const code = this.getAttribute('data-code');
                copyToClipboard(code, 'Code copied!');
            });
        });
        
        // Set up method tabs
        document.querySelectorAll('.method-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.method-tab').forEach(t => {
                    t.classList.remove('active');
                });
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                const target = this.getAttribute('data-target');
                
                // Show/hide result items based on target
                document.querySelectorAll('.result-item').forEach(item => {
                    if (target === 'all' || item.getAttribute('data-type') === target) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Theme toggle
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = themeToggle.querySelector('i');
        
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            
            if (document.body.classList.contains('dark-mode')) {
                themeIcon.classList.remove('bi-moon-stars-fill');
                themeIcon.classList.add('bi-sun-fill');
            } else {
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-stars-fill');
            }
            
            // Save preference
            localStorage.setItem('dark-mode', document.body.classList.contains('dark-mode'));
        });
        
        // Check saved preference
        if (localStorage.getItem('dark-mode') === 'true') {
            document.body.classList.add('dark-mode');
            themeIcon.classList.remove('bi-moon-stars-fill');
            themeIcon.classList.add('bi-sun-fill');
        }
        
        // Set up CSS demo if applicable
        const cssDemo = document.getElementById('css-demo');
        if (cssDemo) {
            const spans = document.querySelectorAll('.obfuscated-email');
            if (spans.length > 0) {
                const clone = spans[0].cloneNode(true);
                
                // Add CSS to reconstruct email
                const style = document.createElement('style');
                style.textContent = `
                    .demo-email::before {
                        content: '';
                    }
                    .demo-email::after {
                        content: '@';
                    }
                    .demo-email .name {
                        unicode-bidi: bidi-override;
                        direction: rtl;
                    }
                    .demo-email .domain {
                        unicode-bidi: bidi-override;
                        direction: rtl;
                    }
                `;
                document.head.appendChild(style);
                
                // Create demo element
                const demoEmail = document.createElement('div');
                demoEmail.className = 'demo-email';
                
                // Extract and decode name
                const nameData = clone.getAttribute('data-name').split(',');
                const decodedName = nameData.map(code => String.fromCharCode(parseInt(code))).join('');
                const nameSpan = document.createElement('span');
                nameSpan.className = 'name';
                nameSpan.textContent = [...decodedName].reverse().join('');
                
                // Extract and decode domain
                const domainData = clone.getAttribute('data-domain').split(',');
                const decodedDomain = domainData.map(code => String.fromCharCode(parseInt(code))).join('');
                const domainSpan = document.createElement('span');
                domainSpan.className = 'domain';
                domainSpan.textContent = [...decodedDomain].reverse().join('');
                
                demoEmail.appendChild(nameSpan);
                demoEmail.appendChild(document.createTextNode('@'));
                demoEmail.appendChild(domainSpan);
                
                cssDemo.appendChild(demoEmail);
            }
        }
    });
    
    // Add toast notification
    function showToast(message) {
        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }
        
        // Create toast
        const toastId = 'toast-' + Date.now();
        const toast = document.createElement('div');
        toast.className = 'toast show';
        toast.id = toastId;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="toast-header">
                <strong class="me-auto"><i class="bi bi-check-circle-fill text-success me-2"></i>Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
    </script>
    
    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "Email Obfuscator",
  "url": "https://infinitytoolspace.com/tools/email-obfuscator",
  "description": "Free tool to hide and protect email addresses from spambots by encoding them into HTML entities or JavaScript.",
  "applicationCategory": "SecurityApplication",
  "operatingSystem": "All",
  "browserRequirements": "Modern browsers supported",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg9EqDkw46_g25sLV1PZo4WGzuzPAmHcFucXU8T51ikbYwCJ3F-fS2lhox_RMD8FsTo-Tz-HCRcx63FwCvv48cuKiQpp5PG5m_xK7rFwuBqKP7WPlzl1nz3UMN3ZgxXte_RHcdSl_LNTbyZRb9XvYWKH-TrcL12sDLuymVGTc-GbtRIXjF-6AMdB1g8P-w/s16000/Email%20Obfuscator.jpg"
}
</script>

</body>
</html>