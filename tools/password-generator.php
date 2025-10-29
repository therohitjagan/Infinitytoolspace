<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Password Generator - InfinityToolSpace</title>
    <meta name="description" content="Generate strong, random, and secure passwords with our free online password generator. Customize length, characters, symbols, and more for better protection.">
    <meta name="keywords" content="password generator, strong password generator, secure password maker, generate password online, random password generator, free password tool, custom password generator">
    <link rel="canonical" href="https://infinitytoolspace.com/tools/password-generator">
    
    <meta property="og:title" content="Password Generator - Create Strong & Secure Passwords" />
<meta property="og:description" content="Use our free password generator to create strong and secure passwords instantly. Customizable length, numbers, symbols, and more." />
<meta property="og:url" content="https://infinitytoolspace.com/tools/password-generator" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiCZV9w4OcctBVcsMdiBiEeOq2L1GJT_W-r1eE2dxXNZsvKHMICB8LKudrgUhxO8Pm6ZvLudm1zSRrqa2qHNoF7jB4wvHA35eFAYdyD4HkcN6ypPvUUDdW0nnuN-jvisxnX6TaZ-1latQZSiUXmg2EFQvHijoU7_BL6jOB_cwzwtp9OD7BfI2YNbm0qNBU/s16000/Strong%20Password%20Generator.jpg" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3250E2;
            --primary-light: #EEF1FD;
            --primary-dark: #1B39C7;
            --secondary-color: #171B2E;
            --text-color: #303545;
            --text-muted: #6B7280;
            --light-bg: #F9FAFC;
            --border-radius: 16px;
            --box-shadow: 0 10px 30px rgba(50, 80, 226, 0.06);
            --card-shadow: 0 12px 32px rgba(19, 27, 48, 0.1);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: var(--light-bg);
            color: var(--text-color);
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            line-height: 1.7;
            padding: 3rem 0;
        }

        .container {
            max-width: 1140px;
        }

        .tool-card {
            background: #FFFFFF;
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: var(--transition);
        }

        .tool-card:hover {
            box-shadow: 0 16px 40px rgba(19, 27, 48, 0.14);
            transform: translateY(-3px);
        }

        .card-header {
            background-color: #FFFFFF;
            border-bottom: 1px solid #F0F2F5;
            padding: 1.5rem 2rem;
        }

        .card-body {
            padding: 2rem;
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--secondary-color);
            font-weight: 700;
        }

        .page-title {
            color: var(--secondary-color);
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 2rem;
            text-align: center;
        }

        .section-title {
            font-size: 1.4rem;
            margin-bottom: 0;
            position: relative;
        }

        .password-display {
            font-family: 'SF Mono', 'Consolas', 'Courier New', monospace;
            font-size: 1.25rem;
            letter-spacing: 1px;
            border: 2px solid #F0F2F5;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.01);
            transition: var(--transition);
        }

        .password-display:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(50, 80, 226, 0.15);
            outline: none;
        }

        .strength-meter {
            height: 8px;
            border-radius: 8px;
            overflow: hidden;
            background-color: #E5E7EB;
            margin-top: 1rem;
        }

        .strength-meter div {
            height: 100%;
            border-radius: 8px;
            transition: var(--transition);
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(50, 80, 226, 0.25);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 6px 16px rgba(50, 80, 226, 0.2);
        }

        .copy-btn {
            transition: var(--transition);
        }

        .toggle-password {
            border-radius: 12px;
            background-color: #F5F7FA;
            border: none;
            color: var(--text-muted);
        }

        .toggle-password:hover {
            background-color: #EEF1FD;
            color: var(--primary-color);
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            border: 2px solid #F0F2F5;
            transition: var(--transition);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(50, 80, 226, 0.15);
        }

        .form-range::-webkit-slider-thumb {
            background: var(--primary-color);
        }

        .form-check-input {
            border-radius: 6px;
            width: 1.3rem;
            height: 1.3rem;
            margin-top: 0.2rem;
            border: 2px solid #E5E7EB;
            transition: var(--transition);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(50, 80, 226, 0.15);
        }

        #passwordHistory {
            max-height: 240px;
            overflow-y: auto;
            border-radius: 12px;
            border: 1px solid #F0F2F5;
            background-color: #FAFBFC;
        }
        
        .history-item {
            cursor: pointer;
            transition: var(--transition);
            border-left: 3px solid transparent;
            padding: 1rem 1.25rem;
        }
        
        .history-item:hover {
            background-color: var(--primary-light);
            border-left: 3px solid var(--primary-color);
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background-color: var(--primary-light);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.25rem;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .feature-icon i {
            font-size: 1.4rem;
        }

        .feature-item:hover .feature-icon {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(50, 80, 226, 0.15);
        }

        .feature-text h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .feature-text p {
            color: var(--text-muted);
            margin-bottom: 0;
        }

        .security-tip {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            border-left: 4px solid var(--primary-color);
            background-color: var(--primary-light);
            transition: var(--transition);
        }

        .security-tip:hover {
            box-shadow: 0 5px 15px rgba(50, 80, 226, 0.1);
            transform: translateX(3px);
        }

        .security-tip i {
            color: var(--primary-color);
            margin-right: 0.75rem;
        }
        
        .faq-item {
            margin-bottom: 1.75rem;
            padding-bottom: 1.75rem;
            border-bottom: 1px solid #F0F2F5;
        }
        
        .faq-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .faq-question {
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--secondary-color);
            font-size: 1.1rem;
        }
        
        .faq-answer {
            color: var(--text-muted);
        }

        .footer-content {
            padding: 2rem 0;
            text-align: center;
            color: var(--text-muted);
        }
        
        .password-stats {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-top: 1.25rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .password-stats span {
            padding: 0.5rem 1rem;
            background-color: #F5F7FA;
            border-radius: 40px;
            display: inline-flex;
            align-items: center;
            transition: var(--transition);
        }
        
        .password-stats span:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }
        
        .password-stats span i {
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .page-header .logo {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }
        
        .page-header .tagline {
            color: var(--text-muted);
            font-size: 1.1rem;
        }
        
        .input-group-text {
            background-color: #F5F7FA;
            border-color: #F0F2F5;
            border-radius: 12px 0 0 12px;
        }
        
        .card-header .section-title::after {
            content: '';
            display: block;
            width: 40px;
            height: 3px;
            background-color: var(--primary-color);
            margin-top: 0.5rem;
            border-radius: 10px;
        }
        
        #strengthText, #existingStrengthText {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.75rem;
        }
        
        #strengthText span, #existingStrengthText span {
            font-weight: 600;
        }
        
        .form-check-label {
            font-weight: 500;
        }
        
        .alert {
            border-radius: 12px;
        }
        
        .btn-sm {
            border-radius: 8px;
            padding: 0.4rem 0.8rem;
        }
        
        .use-password-btn {
            border-radius: 30px;
            padding: 0.25rem 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <div class="logo">InfinityToolSpace</div>
            <div class="tagline">Professional tools for digital productivity</div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="page-title">Secure Password Generator</h1>
                
                <div class="tool-card">
    <div class="card-header">
        <h2 class="section-title">Generate Your Password</h2>
    </div>
    <div class="card-body">
        <div id="errorContainer" class="alert alert-danger d-none">
            <p class="mb-0" id="errorText"></p>
        </div>

        <form id="passwordForm">
            <!-- Password Display Section -->
            <div class="mb-4">
                <label class="form-label fw-bold">Generated Password:</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control password-display" 
                           id="passwordOutput" value="" readonly>
                    <button type="button" class="btn btn-outline-secondary toggle-password" id="togglePassword">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-primary copy-btn" onclick="copyPassword()">
                        <i class="fa-solid fa-copy me-2"></i> Copy
                    </button>
                </div>
                
                <!-- Strength Indicator -->
                <div class="mt-3">
                    <div class="strength-meter" id="strengthMeter">
                        <div></div>
                    </div>
                    <div id="strengthText" class="text-muted d-flex justify-content-between">
                        <div>Password strength:</div>
                        <span>Medium</span>
                    </div>
                </div>
                
                <!-- Password Stats -->
                <div class="password-stats d-flex justify-content-between mt-2">
                    <span><i class="fa-solid fa-stopwatch"></i> Crack time: <span id="crackTime">seconds</span></span>
                    <span><i class="fa-solid fa-shield-halved"></i> Entropy: <span id="entropyValue">0 bits</span></span>
                </div>
            </div>

            <!-- Settings Section -->
            <div class="row g-3">
                <!-- Password Length Slider -->
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold">Password Length: <span id="lengthValue" class="text-primary">16</span></label>
                    <input type="range" class="form-range" min="8" max="128" 
                           name="length" id="length" value="16">
                </div>
                
                <!-- Character Types Section -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="upper" id="upper" checked>
                                <label class="form-check-label" for="upper">Uppercase Letters</label>
                            </div>
                            <div class="input-group input-group-sm" style="width: 100px;">
                                <span class="input-group-text">Min</span>
                                <input type="number" class="form-control" name="min_upper" id="min_upper" min="0" max="10" value="0">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="lower" id="lower" checked>
                                <label class="form-check-label" for="lower">Lowercase Letters</label>
                            </div>
                            <div class="input-group input-group-sm" style="width: 100px;">
                                <span class="input-group-text">Min</span>
                                <input type="number" class="form-control" name="min_lower" id="min_lower" min="0" max="10" value="0">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="numbers" id="numbers" checked>
                                <label class="form-check-label" for="numbers">Numbers</label>
                            </div>
                            <div class="input-group input-group-sm" style="width: 100px;">
                                <span class="input-group-text">Min</span>
                                <input type="number" class="form-control" name="min_numbers" id="min_numbers" min="0" max="10" value="0">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="symbols" id="symbols">
                                <label class="form-check-label" for="symbols">Symbols</label>
                            </div>
                            <div class="input-group input-group-sm" style="width: 100px;">
                                <span class="input-group-text">Min</span>
                                <input type="number" class="form-control" name="min_symbols" id="min_symbols" min="0" max="10" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Exclusion Options -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title">Exclusion Options</h6>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="exclude_similar" id="exclude_similar">
                                <label class="form-check-label" for="exclude_similar">Exclude Similar Characters (e.g., 1, l, I)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="exclude_ambiguous" id="exclude_ambiguous">
                                <label class="form-check-label" for="exclude_ambiguous">Exclude Ambiguous Symbols</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Generate Button -->
            <div class="d-grid gap-2 mt-4">
                <button type="button" class="btn btn-primary btn-lg" id="generateButton">
                    <i class="fa-solid fa-bolt me-2"></i>Generate New Password
                </button>
            </div>
        </form>
    </div>
</div>

                <!-- Password History Card -->
                <div class="tool-card">
                    <div class="card-header">
                        <h2 class="section-title">Password History</h2>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            <i class="fa-solid fa-lock me-2"></i>
                            Passwords are stored locally in your browser and never sent to our servers.
                        </p>
                        <ul class="list-group mb-3" id="passwordHistory">
                            <li class="list-group-item text-center text-muted">No passwords generated yet</li>
                        </ul>
                        <div class="d-grid">
                            <button class="btn btn-outline-danger" id="clearHistoryBtn">
                                <i class="fa-solid fa-trash-can me-2"></i>Clear History
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Password Checker Card -->
                <div class="tool-card">
                    <div class="card-header">
                        <h2 class="section-title">Check Existing Password</h2>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="existingPassword" class="form-label fw-bold">Enter a password to check its strength:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="existingPassword">
                                <button type="button" class="btn btn-outline-secondary toggle-password" 
                                        data-target="existingPassword">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-primary" id="checkPasswordBtn">
                                    <i class="fa-solid fa-shield-halved me-2"></i>Check
                                </button>
                            </div>
                        </div>
                        <div class="mt-3 strength-meter" id="existingStrengthMeter">
                            <div></div>
                        </div>
                        <div id="existingStrengthText" class="text-muted">
                            <div>Password strength:</div>
                            <span>Not checked</span>
                        </div>
                    </div>
                </div>
                
                <!-- Features Section -->
                <div class="tool-card mt-4">
                    <div class="card-header">
                        <h2 class="section-title">Key Features</h2>
                    </div>
                    <div class="card-body">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-solid fa-shield"></i>
                            </div>
                            <div class="feature-text">
                                <h3>High-Strength Passwords</h3>
                                <p>Generate cryptographically secure passwords up to 128 characters long with advanced entropy.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-solid fa-sliders"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Customizable Options</h3>
                                <p>Tailor your passwords with specific character types, minimum requirements, and exclusion rules.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-solid fa-gauge-high"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Strength Analysis</h3>
                                <p>Instantly evaluate password strength with visual indicators and estimated crack time.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <div class="feature-text">
                                <h3>Privacy First</h3>
                                <p>All password generation happens locally in your browser - we never see or store your passwords.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Security Tips Section -->
                <div class="tool-card mt-4">
                    <div class="card-header">
                        <h2 class="section-title">Password Security Tips</h2>
                    </div>
                    <div class="card-body">
                        <div class="security-tip">
                            <i class="fa-solid fa-check-circle"></i>
                            <strong>Length matters.</strong> Use passwords with at least 12-16 characters for better security.
                        </div>
                        
                        <div class="security-tip">
                            <i class="fa-solid fa-check-circle"></i>
                            <strong>Mix character types.</strong> Combine uppercase, lowercase, numbers, and symbols.
                        </div>
                        
                        <div class="security-tip">
                            <i class="fa-solid fa-check-circle"></i>
                            <strong>Use unique passwords.</strong> Never reuse passwords across different sites or services.
                        </div>
                        
                        <div class="security-tip">
                            <i class="fa-solid fa-check-circle"></i>
                            <strong>Consider a password manager.</strong> Tools like 1Password, LastPass, or Bitwarden can help manage unique passwords.
                        </div>
                        
                        <div class="security-tip">
                            <i class="fa-solid fa-check-circle"></i>
                            <strong>Enable two-factor authentication (2FA).</strong> Add an extra layer of security beyond passwords.
                        </div>
                        
                        <div class="security-tip">
                            <i class="fa-solid fa-check-circle"></i>
                            <strong>Change passwords regularly.</strong> Update critical accounts every 90 days.
                        </div>
                        
                        <div class="security-tip">
                            <i class="fa-solid fa-check-circle"></i>
                            <strong>Avoid personal information.</strong> Don't use birthdays, names, or other easily guessable data.
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Section -->
                <div class="tool-card mt-4">
                    <div class="card-header">
                        <h2 class="section-title">Frequently Asked Questions</h2>
                    </div>
                    <div class="card-body">
                        <div class="faq-item">
                            <div class="faq-question">
                                <i class="fa-solid fa-circle-question me-2"></i>
                                What makes a password strong?
                            </div>
                            <div class="faq-answer">
                                Strong passwords are long (12+ characters), use a mix of character types, avoid dictionary words, and are unique for each service. Our generator creates passwords that meet these criteria automatically.
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <i class="fa-solid fa-circle-question me-2"></i>
                                Are my passwords stored on your servers?
                            </div>
                            <div class="faq-answer">
                                No. All password generation happens locally in your browser. Your passwords are never transmitted to or stored on our servers, ensuring maximum privacy and security.
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <i class="fa-solid fa-circle-question me-2"></i>
                                How do I remember all these complex passwords?
                            </div>
                            <div class="faq-answer">
                                We recommend using a password manager like 1Password, LastPass, or Bitwarden. These tools securely store all your passwords, so you only need to remember one master password.
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <i class="fa-solid fa-circle-question me-2"></i>
                                Why should I exclude similar characters?
                            </div>
                            <div class="faq-answer">
                                Excluding similar characters (like 1, l, I) makes passwords easier to read and type correctly, which is helpful when you need to manually enter them. This option is particularly useful for passwords you might need to type from printed materials.
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <div class="faq-question">
                                <i class="fa-solid fa-circle-question me-2"></i>
                                How often should I change my passwords?
                            </div>
                            <div class="faq-answer">
                                Security experts now recommend changing passwords only when there's a reason to believe they've been compromised. However, for critical accounts (banking, email), changing every 90 days is still good practice.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Content Section -->
    <footer class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="footer-content">
                    <h2 class="h5">Secure Password Generator - InfinityToolSpace</h2>
                    <p class="text-muted small">Generate strong, random passwords instantly with our free online password generator. Create secure passwords for all your online accounts with customizable options including length, character types, and exclusion of similar characters. Our tool helps you maintain online security by creating hack-resistant passwords that meet modern security standards. Regularly updating your passwords with our generator can significantly improve your digital security posture.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password history management
        let passwordHistory = JSON.parse(localStorage.getItem('passwordHistory')) || [];
        
        function updateHistoryDisplay() {
            const historyContainer = document.getElementById('passwordHistory');
            if (passwordHistory.length === 0) {
                historyContainer.innerHTML = '<li class="list-group-item text-center text-muted">No passwords generated yet</li>';
                return;
            }
            
            historyContainer.innerHTML = '';
            passwordHistory.slice(0, 10).forEach((password, index) => {
                const item = document.createElement('li');
                item.classList.add('list-group-item', 'history-item', 'd-flex', 'justify-content-between', 'align-items-center');
                item.innerHTML = `
                    <span class="password-text">${'•'.repeat(password.length)}</span>
                    <div>
                        <small class="text-muted me-2">Length: ${password.length}</small>
                        <button class="btn btn-sm btn-outline-primary use-password-btn" data-password="${password}">Use</button>
                    </div>
                `;
                historyContainer.appendChild(item);
                
                // Add event listener to the "Use" button
                item.querySelector('.use-password-btn').addEventListener('click', function() {
                    document.getElementById('passwordOutput').value = this.dataset.password;
                    updateStrengthMeter(this.dataset.password);
                });
            });
        }
        
        // Initialize the history display
        updateHistoryDisplay();
        
        // Clear history
        document.getElementById('clearHistoryBtn').addEventListener('click', function(){
            if (confirm('Are you sure you want to clear your password history?')) {
                passwordHistory = [];
                localStorage.removeItem('passwordHistory');
                updateHistoryDisplay();
            }
        });
        
        // Update length display
        const lengthSlider = document.getElementById('length');
        const lengthValue = document.getElementById('lengthValue');
        lengthSlider.addEventListener('input', () => {
            lengthValue.textContent = lengthSlider.value;
        });

        // Copy to clipboard
        function copyPassword() {
            const passwordField = document.getElementById('passwordOutput');
            navigator.clipboard.writeText(passwordField.value).then(() => {
                const btn = document.querySelector('.copy-btn');
                btn.innerHTML = '<i class="fa-solid fa-check me-2"></i> Copied!';
                setTimeout(() => btn.innerHTML = '<i class="fa-solid fa-copy me-2"></i> Copy', 2000);
            });
        }

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('passwordOutput');
            const icon = this.querySelector('i');
            
            if (passwordField.getAttribute('type') === 'text') {
                passwordField.setAttribute('type', 'password');
                icon.className = 'fa-solid fa-eye';
            } else {
                passwordField.setAttribute('type', 'text');
                icon.className = 'fa-solid fa-eye-slash';
            }
        });
        
        // Toggle password visibility for check existing password
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target') || 'existingPassword';
                const passwordField = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (passwordField.getAttribute('type') === 'text') {
                    passwordField.setAttribute('type', 'password');
                    icon.className = 'fa-solid fa-eye';
                } else {
                    passwordField.setAttribute('type', 'text');
                    icon.className = 'fa-solid fa-eye-slash';
                }
            });
        });

        // Calculate password entropy
        function calculateEntropy(password) {
            if (!password) return 0;
            
            let poolSize = 0;
            const hasUpper = /[A-Z]/.test(password);
            const hasLower = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSymbol = /[^A-Za-z0-9]/.test(password);
            
            if (hasUpper) poolSize += 26;
            if (hasLower) poolSize += 26;
            if (hasNumber) poolSize += 10;
            if (hasSymbol) poolSize += 33;
            
            return Math.log2(Math.pow(poolSize, password.length));
        }
        
        // Estimate crack time based on entropy
        function estimateCrackTime(entropy) {
            const guessesPerSecond = 1000000000; // 1 billion guesses per second (modern hardware)
            const seconds = Math.pow(2, entropy) / guessesPerSecond;
            
            if (seconds < 60) return "seconds";
            if (seconds < 3600) return Math.floor(seconds / 60) + " minutes";
            if (seconds < 86400) return Math.floor(seconds / 3600) + " hours";
            if (seconds < 2592000) return Math.floor(seconds / 86400) + " days";
            if (seconds < 31536000) return Math.floor(seconds / 2592000) + " months";
            return Math.floor(seconds / 31536000) + " years";
        }

        // Password strength calculation
        function calculateStrength(password) {
            if (!password) return 0;
            
            let strength = 0;
            
            // Length contribution (up to 40 points)
            strength += Math.min(password.length * 2.5, 40);
            
            // Character diversity (up to 60 points)
            const hasUpper = /[A-Z]/.test(password);
            const hasLower = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSymbol = /[^A-Za-z0-9]/.test(password);
            
            const diversityCount = (hasUpper ? 1 : 0) + 
                                 (hasLower ? 1 : 0) + 
                                 (hasNumber ? 1 : 0) + 
                                 (hasSymbol ? 1 : 0);
            
            strength += diversityCount * 15;
            
            return Math.min(strength, 100);
        }
        
        // Update strength meter
        function updateStrengthMeter(password) {
            const strength = calculateStrength(password);
            const entropy = calculateEntropy(password);
            const crackTime = estimateCrackTime(entropy);
            
            // Update strength meter
            const meter = document.getElementById('strengthMeter').querySelector('div');
            meter.style.width = strength + '%';
            
            // Update strength text and color
            const strengthText = document.getElementById('strengthText').querySelector('span');
            const entropyValue = document.getElementById('entropyValue');
            const crackTimeValue = document.getElementById('crackTime');
            
            if (strength < 25) {
                meter.style.backgroundColor = '#e74c3c';
                strengthText.textContent = 'Very Weak';
                strengthText.style.color = '#e74c3c';
            } else if (strength < 50) {
                meter.style.backgroundColor = '#f39c12';
                strengthText.textContent = 'Weak';
                strengthText.style.color = '#f39c12';
            } else if (strength < 75) {
                meter.style.backgroundColor = '#3498db';
                strengthText.textContent = 'Medium';
                strengthText.style.color = '#3498db';
            } else if (strength < 90) {
                meter.style.backgroundColor = '#2ecc71';
                strengthText.textContent = 'Strong';
                strengthText.style.color = '#2ecc71';
            } else {
                meter.style.backgroundColor = '#27ae60';
                strengthText.textContent = 'Very Strong';
                strengthText.style.color = '#27ae60';
            }
            
            // Update entropy and crack time
            entropyValue.textContent = entropy.toFixed(1) + ' bits';
            crackTimeValue.textContent = crackTime;
        }
        
        // Generate password
        function generatePassword() {
            const length = parseInt(document.getElementById('length').value);
            const useUpper = document.getElementById('upper').checked;
            const useLower = document.getElementById('lower').checked;
            const useNumbers = document.getElementById('numbers').checked;
            const useSymbols = document.getElementById('symbols').checked;
            const excludeSimilar = document.getElementById('exclude_similar').checked;
            const excludeAmbiguous = document.getElementById('exclude_ambiguous').checked;
            
            const minUpper = parseInt(document.getElementById('min_upper').value) || 0;
            const minLower = parseInt(document.getElementById('min_lower').value) || 0;
            const minNumbers = parseInt(document.getElementById('min_numbers').value) || 0;
            const minSymbols = parseInt(document.getElementById('min_symbols').value) || 0;
            
            // Character sets
            let upperChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            let lowerChars = 'abcdefghijklmnopqrstuvwxyz';
            let numberChars = '0123456789';
            let symbolChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';
            
            // Exclude similar characters if selected
            if (excludeSimilar) {
                upperChars = upperChars.replace(/[IO]/g, '');
                lowerChars = lowerChars.replace(/[l]/g, '');
                numberChars = numberChars.replace(/[10]/g, '');
            }
            
            // Exclude ambiguous symbols if selected
            if (excludeAmbiguous) {
                symbolChars = symbolChars.replace(/[{}[\]()\/\\'"~,;:.<>]/g, '');
            }
            
            // Check if at least one character set is selected
            if (!useUpper && !useLower && !useNumbers && !useSymbols) {
                showError('Please select at least one character type');
                return '';
            }
            
            // Validate minimum requirements
            const totalMinChars = minUpper + minLower + minNumbers + minSymbols;
            if (totalMinChars > length) {
                showError('Total minimum characters exceeds password length');
                return '';
            }
            
            // Build character pool
            let charPool = '';
            if (useUpper) charPool += upperChars;
            if (useLower) charPool += lowerChars;
            if (useNumbers) charPool += numberChars;
            if (useSymbols) charPool += symbolChars;
            
            // Generate password
            let password = '';
            
            // Add minimum required characters
            if (useUpper && minUpper > 0) {
                for (let i = 0; i < minUpper; i++) {
                    password += upperChars.charAt(Math.floor(Math.random() * upperChars.length));
                }
            }
            
            if (useLower && minLower > 0) {
                for (let i = 0; i < minLower; i++) {
                    password += lowerChars.charAt(Math.floor(Math.random() * lowerChars.length));
                }
            }
            
            if (useNumbers && minNumbers > 0) {
                for (let i = 0; i < minNumbers; i++) {
                    password += numberChars.charAt(Math.floor(Math.random() * numberChars.length));
                }
            }
            
            if (useSymbols && minSymbols > 0) {
                for (let i = 0; i < minSymbols; i++) {
                    password += symbolChars.charAt(Math.floor(Math.random() * symbolChars.length));
                }
            }
            
            // Fill remaining length with random chars from pool
            const remainingLength = length - password.length;
            for (let i = 0; i < remainingLength; i++) {
                password += charPool.charAt(Math.floor(Math.random() * charPool.length));
            }
            
            // Shuffle the password to mix the minimum required characters
            password = shuffleString(password);
            
            // Clear error if any
            hideError();
            
            return password;
        }
        
        // Shuffle string
        function shuffleString(string) {
            const array = string.split('');
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array.join('');
        }
        
        // Show error message
        function showError(message) {
            const errorContainer = document.getElementById('errorContainer');
            const errorText = document.getElementById('errorText');
            errorText.textContent = message;
            errorContainer.classList.remove('d-none');
        }
        
        // Hide error message
        function hideError() {
            document.getElementById('errorContainer').classList.add('d-none');
        }
        
        // Generate button event
        document.getElementById('generateButton').addEventListener('click', function() {
            const password = generatePassword();
            if (password) {
                document.getElementById('passwordOutput').value = password;
                updateStrengthMeter(password);
                
                // Add to history
                if (password && !passwordHistory.includes(password)) {
                    passwordHistory.unshift(password);
                    if (passwordHistory.length > 10) {
                        passwordHistory.pop();
                    }
                    localStorage.setItem('passwordHistory', JSON.stringify(passwordHistory));
                    updateHistoryDisplay();
                }
            }
        });
        
        // Check existing password
        document.getElementById('checkPasswordBtn').addEventListener('click', function() {
            const password = document.getElementById('existingPassword').value;
            if (!password) {
                return;
            }
            
            const strength = calculateStrength(password);
            
            // Update strength meter
            const meter = document.getElementById('existingStrengthMeter').querySelector('div');
            meter.style.width = strength + '%';
            
            // Update strength text
            const strengthText = document.getElementById('existingStrengthText').querySelector('span');
            
            if (strength < 25) {
                meter.style.backgroundColor = '#e74c3c';
                strengthText.textContent = 'Very Weak';
                strengthText.style.color = '#e74c3c';
            } else if (strength < 50) {
                meter.style.backgroundColor = '#f39c12';
                strengthText.textContent = 'Weak';
                strengthText.style.color = '#f39c12';
            } else if (strength < 75) {
                meter.style.backgroundColor = '#3498db';
                strengthText.textContent = 'Medium';
                strengthText.style.color = '#3498db';
            } else if (strength < 90) {
                meter.style.backgroundColor = '#2ecc71';
                strengthText.textContent = 'Strong';
                strengthText.style.color = '#2ecc71';
            } else {
                meter.style.backgroundColor = '#27ae60';
                strengthText.textContent = 'Very Strong';
                strengthText.style.color = '#27ae60';
            }
        });
        
        // Generate initial password when page loads
        window.addEventListener('DOMContentLoaded', function() {
            document.getElementById('generateButton').click();
        });
    </script>
    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "Password Generator",
  "url": "https://infinitytoolspace.com/tools/password-generator",
  "description": "Generate strong, secure passwords online. Customize character types, length, and more with our free and easy-to-use password maker tool.",
  "applicationCategory": "SecurityApplication",
  "operatingSystem": "All",
  "browserRequirements": "Modern browser",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiCZV9w4OcctBVcsMdiBiEeOq2L1GJT_W-r1eE2dxXNZsvKHMICB8LKudrgUhxO8Pm6ZvLudm1zSRrqa2qHNoF7jB4wvHA35eFAYdyD4HkcN6ypPvUUDdW0nnuN-jvisxnX6TaZ-1latQZSiUXmg2EFQvHijoU7_BL6jOB_cwzwtp9OD7BfI2YNbm0qNBU/s16000/Strong%20Password%20Generator.jpg"
}
</script>

</body>
</html>