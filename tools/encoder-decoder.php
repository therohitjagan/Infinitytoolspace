<?php
// Handle Form Submission


$result = '';
$error = '';
$operations = [
    'url_encode' => 'URL Encode',
    'url_decode' => 'URL Decode',
    'base64_encode' => 'Base64 Encode',
    'base64_decode' => 'Base64 Decode',
    'html_entities' => 'HTML Entities',
    'html_entity_decode' => 'HTML Decode',
    'md5_hash' => 'MD5 Hash',
    'sha1_hash' => 'SHA1 Hash',
    'json_encode' => 'JSON Encode',
    'json_decode' => 'JSON Decode'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['input'] ?? '';
    $operation = $_POST['operation'] ?? '';
    
    try {
        switch ($operation) {
            case 'url_encode':
                $result = urlencode($input);
                break;
            case 'url_decode':
                $result = urldecode($input);
                break;
            case 'base64_encode':
                $result = base64_encode($input);
                break;
            case 'base64_decode':
                $result = base64_decode($input);
                if (base64_decode($input, true) === false) {
                    throw new Exception('Invalid Base64 input');
                }
                break;
            case 'html_entities':
                $result = htmlentities($input, ENT_QUOTES);
                break;
            case 'html_entity_decode':
                $result = html_entity_decode($input);
                break;
            case 'md5_hash':
                $result = md5($input);
                break;
            case 'sha1_hash':
                $result = sha1($input);
                break;
            case 'json_encode':
                $result = json_encode($input, JSON_PRETTY_PRINT);
                break;
            case 'json_decode':
                $result = json_decode($input);
                $result = print_r($result, true);
                break;
            default:
                throw new Exception('Invalid operation');
                // Add this case to your switch statement in the PHP section
case 'file_base64':
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $result = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
    } else {
        throw new Exception('No file uploaded or error during upload');
    }
    break;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Encoder/Decoder | URL, Base64, HTML, JSON Tools</title>
    <meta name="description" content="Advanced online encoding/decoding tool with support for URL, Base64, HTML, JSON, MD5, SHA1 and more. Developer-friendly web utilities with instant results.">
    <meta name="keywords" content="text encoder, text decoder, base64 encoder, base64 decoder, url encoder, html encoder, utf-8 encoder, text converter, online encoder decoder tool">
    
    <link rel="canonical" href="https://infinitytoolspace.com/tools/encoder-decoder" />
    
    <meta property="og:title" content="Text Encoder & Decoder - Base64, URL, HTML, UTF-8" />
<meta property="og:description" content="Free online tool to encode or decode strings using Base64, URL, HTML, UTF-8 formats. Simple and fast for developers and data work." />
<meta property="og:url" content="https://infinitytoolspace.com/tools/encoder-decoder" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjGXPVjIijCrQpKidnXTkx0zo4F_SN6Ld0HvyIiFaqxVgDfCDvull5lZSONWl-pULtLBLqzo9NOt7WEwpJ9ZzFIwR-vGsKyZrAMl0m7LpQ2N8UNW0QBgwfbynKMw0UUVCPEfK4U3J-El9yf98VMLWvHlFSiBhLCAgzhgBinvsWoK3U0YIKLDeajmudIz5I/s16000/Color%20Palette%20Generator%20(1).jpg" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>


    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #6366f1;
            --primary-gradient: linear-gradient(135deg, #6366f1, #4f46e5);
            --primary-light: rgba(99, 102, 241, 0.1);
            --secondary: #4f46e5;
            --accent: #ec4899;
            --accent-gradient: linear-gradient(135deg, #ec4899, #d946ef);
            --success: #10b981;
            --error: #ef4444;
            --bg-gradient: linear-gradient(135deg, #f9fafb, #f3f4f6);
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-radius: 12px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        }
        
    
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            color: var(--text-primary);
            padding: 2rem 0;
        }
        
        .main-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: none;
            overflow: hidden;
        }
        
        .card-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .operation-btn {
            background: white;
            color: var(--primary);
            border: 1px solid var(--primary-light);
            border-radius: 8px;
            padding: 10px 15px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }
        
        .operation-btn:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .operation-btn i {
            margin-right: 6px;
            font-size: 0.8rem;
        }
        
        .primary-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }
        
        .primary-btn:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .secondary-btn {
            background: white;
            color: var(--text-secondary);
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        
        .secondary-btn:hover {
            background: #f8fafc;
        }
        
        .nav-pills {
            border-radius: 10px;
            background: #f8fafc;
            padding: 5px;
            margin-bottom: 1.5rem;
        }
        
        .nav-link {
            color: var(--text-secondary);
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            margin: 0 5px;
            transition: all 0.2s ease;
        }
        
        .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }
        
        .nav-link i {
            margin-right: 6px;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 0.95rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        textarea.form-control, pre.form-control {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .char-count {
            position: absolute;
            right: 1rem;
            bottom: 1rem;
            font-size: 0.8rem;
            color: var(--text-secondary);
            background: rgba(255,255,255,0.8);
            padding: 2px 8px;
            border-radius: 4px;
        }
        
        .operation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }
        
        .result-container {
            position: relative;
            margin-top: 2rem;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .result-header {
            background: #f8fafc;
            padding: 10px 15px;
            font-weight: 500;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .copy-btn {
            background: transparent;
            color: var(--text-secondary);
            border: none;
            font-size: 0.9rem;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .copy-btn:hover {
            background: #f1f5f9;
            color: var(--primary);
        }
        
        .copy-btn i {
            margin-right: 5px;
        }
        
        pre#result {
            margin: 0;
            padding: 15px;
            max-height: 300px;
            overflow: auto;
            background: white;
            border: none;
            color: var(--text-primary);
        }
        
        .success-toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--success);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .success-toast.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .success-toast i {
            margin-right: 10px;
        }
        
        .file-upload {
            border: 2px dashed #e2e8f0;
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .file-upload:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }
        
        .file-upload i {
            font-size: 2rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }
        
        .seo-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-top: 3rem;
            box-shadow: var(--shadow-md);
        }
        
        .seo-section h2 {
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }
        
        .seo-section p {
            color: var(--text-secondary);
            line-height: 1.6;
        }
        
        .feature-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 1.5rem 0;
        }
        
        .feature-item {
            background: #f8fafc;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            color: var(--text-secondary);
            display: inline-flex;
            align-items: center;
        }
        
        .feature-item i {
            margin-right: 8px;
            color: var(--primary);
        }
        
        .error-message {
            color: var(--error);
            font-size: 0.9rem;
            margin-top: 5px;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="main-card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0"><i class="fas fa-code me-2"></i>Advanced Encoder/Decoder</h1>
                    <button class="secondary-btn" id="clearAll">
                        <i class="fas fa-eraser me-1"></i>Clear All
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#text-tab">
                            <i class="fas fa-text-width"></i>Text Tools
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#file-tab">
                            <i class="fas fa-file"></i>File Tools
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content">
    <!-- Text Tools Tab -->
    <div class="tab-pane fade show active" id="text-tab">
        <form method="post" id="text-form">
            <div class="mb-4 position-relative">
                <label class="form-label" for="input">Input Text:</label>
                <textarea class="form-control" 
                         id="input" 
                         name="input" 
                         rows="5"
                         placeholder="Enter text to process..."
                         required><?= htmlspecialchars($_POST['input'] ?? '') ?></textarea>
                <div class="char-count" id="input-count">0 characters</div>
            </div>
                            
            <input type="hidden" name="operation" id="hidden-operation" value="">

<!-- Keep your buttons but change them to regular buttons -->
<div class="mb-4">
    <label class="form-label">Select Operation:</label>
    <div class="operation-grid">
        <?php foreach ($operations as $key => $label): ?>
        <button type="button" class="operation-btn" onclick="submitWithOperation('<?= $key ?>')">
            <i class="fas fa-<?= strpos($key, 'decode') !== false ? 'arrow-down' : (strpos($key, 'hash') !== false ? 'lock' : 'arrow-up') ?>"></i>
            <?= $label ?>
        </button>
        <?php endforeach; ?>
    </div>
</div>
                            
                            <?php if ($result !== '' || $error !== ''): ?>
                            <div class="result-container animate-fade-in">
                                <div class="result-header">
                                    <span>Result <?= $error ? '(Error)' : '' ?></span>
                                    <?php if (!$error): ?>
                                    <button type="button" class="copy-btn" onclick="copyToClipboard()">
                                        <i class="fas fa-copy"></i>Copy
                                    </button>
                                    <?php endif; ?>
                                </div>
                                <pre id="result" class="<?= $error ? 'text-danger' : '' ?>"><?= htmlspecialchars($error ? "Error: $error" : $result) ?></pre>
                                <?php if (!$error): ?>
                                <div class="char-count" id="result-count"><?= strlen($result) ?> characters</div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </form>
                    </div>
                    
                    <!-- File Tools Tab -->
                    <!-- File Tools Tab -->
<div class="tab-pane fade" id="file-tab">
    <form method="post" enctype="multipart/form-data" id="file-form">
        <div class="mb-4">
            <label class="form-label" for="fileInput">Upload File (Max 5MB):</label>
            <div class="file-upload" id="dropArea">
                <i class="fas fa-cloud-upload-alt"></i>
                <p class="mb-2">Drag & drop your file here or</p>
                <input type="file" class="d-none" name="file" id="fileInput">
                <button type="button" class="primary-btn" id="browseButton">
                    Browse File
                </button>
                <div id="fileInfo" class="mt-3 text-muted"></div>
            </div>
        </div>
        
        <div class="mb-4">
            <!-- Add a hidden input for the operation -->
            <input type="hidden" name="operation" value="file_base64">
            <button type="submit" class="primary-btn" id="encodeFileBtn" disabled>
                <i class="fas fa-file-code me-1"></i>Base64 Encode File
            </button>
        </div>
    </form>
</div>
                </div>
            </div>
        </div>
        
        <!-- SEO Section -->
        <div class="seo-section">
            <h2>Advanced Online Encoding/Decoding Tool</h2>
            <p>
                Our comprehensive online encoder/decoder provides instant conversion for multiple formats including URL, 
                Base64, HTML entities, JSON, and cryptographic hashes. Perfect for developers, security professionals,
                and anyone working with web technologies.
            </p>
            
            <div class="feature-list">
                <div class="feature-item"><i class="fas fa-link"></i>URL Encoding</div>
                <div class="feature-item"><i class="fas fa-code"></i>Base64 Conversion</div>
                <div class="feature-item"><i class="fas fa-file-code"></i>HTML Entities</div>
                <div class="feature-item"><i class="fas fa-brackets-curly"></i>JSON Formatting</div>
                <div class="feature-item"><i class="fas fa-lock"></i>MD5 & SHA1 Hashing</div>
                <div class="feature-item"><i class="fas fa-file-upload"></i>File to Base64</div>
                <div class="feature-item"><i class="fas fa-text-size"></i>Character Counting</div>
                <div class="feature-item"><i class="fas fa-shield-alt"></i>Client-side Processing</div>
            </div>
            
            <p>
                All processing happens locally in your browser for maximum security. No data is sent to our servers
                except when explicitly submitted through the form. Ideal for developers working with web APIs, data 
                serialization, security implementations, and content formatting.
            </p>
        </div>
    </div>

    <!-- Success Toast -->
    <div class="success-toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toast-message">Copied to clipboard!</span>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>

function submitWithOperation(operation) {
    document.getElementById('hidden-operation').value = operation;
    document.getElementById('text-form').submit();
}
        // Character Count
        const inputField = document.getElementById('input');
        const inputCount = document.getElementById('input-count');
        
        // Initialize counter
        if (inputField) {
            inputCount.textContent = `${inputField.value.length} characters`;
            
            inputField.addEventListener('input', function(e) {
                inputCount.textContent = `${e.target.value.length} characters`;
            });
        }

        // Copy Function
        function copyToClipboard() {
            const result = document.getElementById('result');
            navigator.clipboard.writeText(result.innerText);
            showToast('Copied to clipboard!');
        }
        
        function copyFileResult() {
            const result = document.getElementById('fileResult');
            navigator.clipboard.writeText(result.innerText);
            showToast('Copied to clipboard!');
        }
        
        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Clear All
        document.getElementById('clearAll').addEventListener('click', () => {
            document.getElementById('input').value = '';
            const resultElement = document.getElementById('result');
            if (resultElement) {
                resultElement.textContent = '';
                document.querySelector('.result-container').style.display = 'none';
            }
            document.getElementById('input-count').textContent = '0 characters';
        });

        // File Input Handler
        const fileInput = document.getElementById('fileInput');
        const dropArea = document.getElementById('dropArea');
        const fileInfo = document.getElementById('fileInfo');
        const encodeFileBtn = document.getElementById('encodeFileBtn');
        const browseButton = document.getElementById('browseButton');
        
        // File browse button
        browseButton.addEventListener('click', () => {
            fileInput.click();
        });
        
        // File input change handler
        fileInput.addEventListener('change', function(e) {
            handleFiles(this.files);
        });
        
        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropArea.style.borderColor = '#6366f1';
            dropArea.style.background = 'rgba(99, 102, 241, 0.1)';
        }
        
        function unhighlight() {
            dropArea.style.borderColor = '#e2e8f0';
            dropArea.style.background = 'transparent';
        }
        
        dropArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }
        
        function handleFiles(files) {
            if (files.length) {
                const file = files[0];
                
                if (file.size > 5 * 1024 * 1024) {
                    fileInfo.innerHTML = '<span class="error-message">File size exceeds 5MB limit</span>';
                    encodeFileBtn.disabled = true;
                    fileInput.value = '';
                    return;
                }
                
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                fileInfo.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file me-2"></i>
                        <div>
                            <strong>${file.name}</strong>
                            <div>${fileSizeMB} MB</div>
                        </div>
                    </div>
                `;
                encodeFileBtn.disabled = false;
            }
        }
        
        // Form submission - show loading state
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitButtons = this.querySelectorAll('button[type="submit"]');
                submitButtons.forEach(button => {
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Processing...';
                    button.disabled = true;
                    
                    // Reset button state after submission (for browsers that don't navigate)
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 3000);
                });
            });
        });
        
        // Initialize elements after page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial character counts
            if (inputField) {
                inputCount.textContent = `${inputField.value.length} characters`;
            }
            
            // Initialize file button state
            if (encodeFileBtn) {
                encodeFileBtn.disabled = true;
            }
        });
        function submitOperation(operation) {
    document.getElementById('operation-input').value = operation;
    document.getElementById('text-form').submit();
}
    </script>
    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "Text Encoder & Decoder",
  "url": "https://infinitytoolspace.com/tools/encoder-decoder",
  "description": "Free online encoder and decoder for Base64, URL, HTML, and UTF-8 text. Ideal for developers, programmers, and data processing tasks.",
  "applicationCategory": "DeveloperApplication",
  "operatingSystem": "All",
  "browserRequirements": "Supports all modern browsers",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjGXPVjIijCrQpKidnXTkx0zo4F_SN6Ld0HvyIiFaqxVgDfCDvull5lZSONWl-pULtLBLqzo9NOt7WEwpJ9ZzFIwR-vGsKyZrAMl0m7LpQ2N8UNW0QBgwfbynKMw0UUVCPEfK4U3J-El9yf98VMLWvHlFSiBhLCAgzhgBinvsWoK3U0YIKLDeajmudIz5I/s16000/Color%20Palette%20Generator%20(1).jpg"
}
</script>

</body>
</html>
<?php include("../footer.php")?>