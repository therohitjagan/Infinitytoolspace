<?php
// Text transformation functions
function formatText($text, $operation, $separator = '') {
    switch ($operation) {
        case 'uppercase': return strtoupper($text);
        case 'lowercase': return strtolower($text);
        case 'title_case': return ucwords(strtolower($text));
        case 'sentence_case':
            return preg_replace_callback('/[.!?] .*?\w/', function($matches) {
                return strtoupper($matches[0]);
            }, ucfirst(strtolower($text)));
        case 'alternating': return alternatingCase($text);
        case 'inverse': return inverseCase($text);
        case 'camel': return camelCase($text);
        case 'pascal': return pascalCase($text);
        case 'snake': return snake_case($text, $separator ?: '_');
        case 'kebab': return kebabCase($text, $separator ?: '-');
        case 'studly': return studlyCase($text);
        case 'leet': return leetSpeak($text);
        case 'reverse': return strrev($text);
        default: return $text;
    }
}

function alternatingCase($text) {
    $result = '';
    $upper = true;
    foreach (str_split($text) as $char) {
        $result .= $upper ? strtoupper($char) : strtolower($char);
        if (ctype_alpha($char)) $upper = !$upper;
    }
    return $result;
}

function inverseCase($text) {
    return preg_replace_callback('/./', function($matches) {
        $c = $matches[0];
        return ctype_lower($c) ? strtoupper($c) : strtolower($c);
    }, $text);
}

function camelCase($text) {
    return lcfirst(str_replace(' ', '', ucwords(strtolower(preg_replace('/[^a-zA-Z0-9]/', ' ', $text)))));
}

function pascalCase($text) {
    return str_replace(' ', '', ucwords(strtolower(preg_replace('/[^a-zA-Z0-9]/', ' ', $text))));
}

function snake_case($text, $separator = '_') {
    return strtolower(preg_replace(['/[^a-zA-Z0-9]/', '/\s+/'], [$separator, $separator], $text));
}

function kebabCase($text, $separator = '-') {
    return strtolower(preg_replace(['/[^a-zA-Z0-9]/', '/\s+/'], [$separator, $separator], $text));
}

function studlyCase($text) {
    return preg_replace_callback('/./', function($matches) {
        return rand(0, 1) ? strtoupper($matches[0]) : strtolower($matches[0]);
    }, $text);
}

function leetSpeak($text) {
    $leetMap = [
        'a' => '4', 'A' => '4',
        'e' => '3', 'E' => '3',
        'i' => '1', 'I' => '1',
        'o' => '0', 'O' => '0',
        's' => '5', 'S' => '5',
        't' => '7', 'T' => '7',
        'b' => '8', 'B' => '8',
        'g' => '9', 'G' => '9'
    ];
    return strtr($text, $leetMap);
}

// Process form submission
$result = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['text'] ?? '';
    $operation = $_POST['operation'] ?? '';
    $separator = $_POST['separator'] ?? '';
    $result = formatText($text, $operation, $separator);
}

// Helper function for select options
function selected($value) {
    return ($_POST['operation'] ?? '') === $value ? 'selected' : '';
}

// Function to download text file
if(isset($_POST['download']) && isset($_POST['result'])) {
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="formatted_text.txt"');
    echo $_POST['result'];
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TextMaster - Ultimate Text Formatter</title>
    <meta name="description" content="Free online text formatting tool with 15+ transformations including case converter, leet speak, reverse text, and programming case styles. Perfect for developers and content creators.">
    <meta name="keywords" content="text formatter, format text online, clean text, beautify text, reformat text, fix spacing, text editing tool, text cleaner, online text tool">
    <link rel="canonical" href="https://infinitytoolspace.com/tools/formatter" />
    
    <meta property="og:title" content="Text Formatter - Clean, Beautify & Format Your Text" />
<meta property="og:description" content="Clean, reformat, and beautify your text with our free online text formatter tool. Perfect for writers, coders, and students." />
<meta property="og:url" content="https://infinitytoolspace.com/tools/formatter" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgso1jKWZgEPmkVK97-_8DTJwRJxPSDkF0RPBa5setQaBRWrLwt5oyKb0gzIHkcqmcEYnw6EhwerU_K2dlmwOM8LLyb13ddcYazqyOEpASG0z-qD6gigkPXnaRLPCQQHL7arYIT8wH_9d2E48CYQfiYUNCpuBSzcWm_w7aCQSrHHTc7fKD3Uf_QBQFln9s/s16000/formatter_image.jpeg" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>


    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6366F1;
            --primary-light: #818CF8;
            --primary-dark: #4F46E5;
            --secondary-color: #10B981;
            --bg-color: #F9FAFB;
            --card-bg: #FFFFFF;
            --text-color: #1F2937;
            --border-radius: 1rem;
            --box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            line-height: 1.6;
        }
        
        .main-container {
            max-width: 1000px;
            padding: 2rem 1rem;
        }
        
        .app-title {
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 2.5rem;
        }
        
        .app-title span {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .card-header {
            background-color: rgba(99, 102, 241, 0.05);
            border-bottom: 1px solid rgba(99, 102, 241, 0.1);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--primary-dark);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        textarea {
            border: 1px solid #E5E7EB;
            border-radius: 0.75rem;
            padding: 1rem;
            width: 100%;
            font-family: 'Inter', sans-serif;
            transition: var(--transition);
            min-height: 180px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        
        textarea:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        
        .form-select {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #E5E7EB;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .form-select:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        
        .btn {
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
            border: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            border: 1px solid #E5E7EB;
            background-color: white;
            color: var(--text-color);
        }
        
        .btn-outline:hover {
            border-color: var(--primary-light);
            color: var(--primary-color);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #0DA271;
            transform: translateY(-2px);
        }
        
        .btn-icon {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .text-stats {
            font-size: 0.9rem;
            color: #6B7280;
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
        }
        
        .separator-input {
            border-radius: 0.75rem;
            border: 1px solid #E5E7EB;
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }
        
        .feature-badge {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
        
        .settings-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        
        .settings-group {
            flex: 1;
            min-width: 200px;
        }
        
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: var(--box-shadow);
            display: none;
            z-index: 1000;
        }
        
        .separator-container {
            display: none;
        }
        
        @media (max-width: 768px) {
            .settings-row {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container main-container">
        <h1 class="app-title"><span>TextMaster</span> <small class="text-muted">Pro</small> - Infinitytoolspace</h1>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-keyboard me-2"></i>Input Text</span>
                <div>
                    <span class="feature-badge">Live Preview</span>
                    <span class="feature-badge">Real-time Stats</span>
                </div>
            </div>
            <div class="card-body">
                <form method="post" id="formatterForm">
                    <div class="mb-3">
                        <textarea class="form-control" name="text" id="textInput" 
                            placeholder="Enter your text here..." required><?= htmlspecialchars($_POST['text'] ?? '') ?></textarea>
                        <div class="text-stats">
                            <div id="charCount">0 characters</div>
                            <div id="wordCount">0 words</div>
                        </div>
                    </div>
                    
                    <div class="settings-row">
                        <div class="settings-group">
                            <label class="mb-2">Transformation Type</label>
                            <select class="form-select" name="operation" id="operationSelect" required>
                                <option value="">Select Transformation</option>
                                <optgroup label="Basic Cases">
                                    <option value="uppercase" <?= selected('uppercase') ?>>UPPERCASE</option>
                                    <option value="lowercase" <?= selected('lowercase') ?>>lowercase</option>
                                    <option value="title_case" <?= selected('title_case') ?>>Title Case</option>
                                    <option value="sentence_case" <?= selected('sentence_case') ?>>Sentence case</option>
                                </optgroup>
                                <optgroup label="Programming Cases">
                                    <option value="camel" <?= selected('camel') ?>>camelCase</option>
                                    <option value="pascal" <?= selected('pascal') ?>>PascalCase</option>
                                    <option value="snake" <?= selected('snake') ?>>snake_case</option>
                                    <option value="kebab" <?= selected('kebab') ?>>kebab-case</option>
                                </optgroup>
                                <optgroup label="Fun Transformations">
                                    <option value="alternating" <?= selected('alternating') ?>>Alternating Case</option>
                                    <option value="inverse" <?= selected('inverse') ?>>Inverse Case</option>
                                    <option value="studly" <?= selected('studly') ?>>Studly Case</option>
                                    <option value="leet" <?= selected('leet') ?>>Leet Speak</option>
                                    <option value="reverse" <?= selected('reverse') ?>>Reverse Text</option>
                                </optgroup>
                            </select>
                        </div>
                        
                        <div class="settings-group separator-container" id="separatorContainer">
                            <label class="mb-2">Custom Separator</label>
                            <input type="text" class="form-control separator-input" name="separator" id="separatorInput" value="<?= htmlspecialchars($_POST['separator'] ?? '') ?>" placeholder="Custom separator (e.g., _, -, .)">
                        </div>
                        
                        <div class="settings-group">
                            <label class="mb-2">Transform</label>
                            <button type="submit" class="btn btn-primary w-100 btn-icon">
                                <i class="fas fa-magic"></i> Transform Text
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-wand-magic-sparkles me-2"></i>Transformed Text</span>
                <div>
                    <span class="feature-badge">Live Preview</span>
                    <span class="feature-badge">Copy to Clipboard</span>
                </div>
            </div>
            <div class="card-body">
                <textarea class="form-control mb-3" id="resultOutput" readonly><?= htmlspecialchars($result) ?></textarea>
                
                <div class="d-flex gap-2 flex-wrap">
                    <button type="button" class="btn btn-primary btn-icon" id="copyBtn">
                        <i class="fas fa-copy"></i> Copy to Clipboard
                    </button>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="result" id="resultForDownload" value="<?= htmlspecialchars($result) ?>">
                        <button type="submit" name="download" class="btn btn-secondary btn-icon">
                            <i class="fas fa-download"></i> Download as TXT
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- SEO Content -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i>About TextMaster Pro
            </div>
            <div class="card-body">
                <h2 class="h5 mb-3">Advanced Text Transformation Tool</h2>
                <p>TextMaster Pro is a comprehensive text formatting suite designed for writers, developers, and content creators. Our tool offers 15+ different text transformations with advanced features like live preview, custom separators, and export options.</p>
                
                <h3 class="h6 mb-2 mt-4">Key Features:</h3>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="feature-badge"><i class="fas fa-bolt"></i> Live Preview</span>
                    <span class="feature-badge"><i class="fas fa-copy"></i> One-Click Copy</span>
                    <span class="feature-badge"><i class="fas fa-download"></i> Download as TXT</span>
                    <span class="feature-badge"><i class="fas fa-calculator"></i> Word/Character Count</span>
                    <span class="feature-badge"><i class="fas fa-sliders"></i> Custom Separators</span>
                    <span class="feature-badge"><i class="fas fa-globe"></i> Works Offline</span>
                    <span class="feature-badge"><i class="fas fa-mobile-alt"></i> Mobile Friendly</span>
                </div>
                
                <p class="text-muted small">TextMaster Pro is perfect for developers working with different naming conventions, content creators optimizing text formatting, or anyone who needs quick text transformations. Our tool processes everything locally in your browser for maximum privacy and security.</p>
            </div>
        </div>
    </div>

    <div class="toast" id="copyToast">
        <i class="fas fa-check-circle me-2"></i> Copied to clipboard!
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textInput = document.getElementById('textInput');
            const resultOutput = document.getElementById('resultOutput');
            const charCount = document.getElementById('charCount');
            const wordCount = document.getElementById('wordCount');
            const operationSelect = document.getElementById('operationSelect');
            const separatorContainer = document.getElementById('separatorContainer');
            const separatorInput = document.getElementById('separatorInput');
            const copyBtn = document.getElementById('copyBtn');
            const copyToast = document.getElementById('copyToast');
            const resultForDownload = document.getElementById('resultForDownload');
            
            // Update character and word count
            function updateCounts() {
                const text = textInput.value;
                const chars = text.length;
                const words = text.trim() ? text.trim().split(/\s+/).length : 0;
                
                charCount.textContent = chars + (chars === 1 ? ' character' : ' characters');
                wordCount.textContent = words + (words === 1 ? ' word' : ' words');
            }
            
            // Show/hide separator input based on selected operation
            function toggleSeparatorInput() {
                const operation = operationSelect.value;
                if (operation === 'snake' || operation === 'kebab') {
                    separatorContainer.style.display = 'block';
                } else {
                    separatorContainer.style.display = 'none';
                }
            }
            
            // Live preview functionality
            async function livePreview() {
                const text = textInput.value;
                const operation = operationSelect.value;
                const separator = separatorInput.value;
                
                if (!text || !operation) {
                    resultOutput.value = '';
                    return;
                }
                
                // Create form data for the AJAX request
                const formData = new FormData();
                formData.append('text', text);
                formData.append('operation', operation);
                formData.append('separator', separator);
                
                try {
                    const response = await fetch(window.location.href, {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const result = doc.getElementById('resultOutput').value;
                    
                    resultOutput.value = result;
                    resultForDownload.value = result;
                } catch (error) {
                    console.error('Live preview error:', error);
                }
            }
            
            // Copy to clipboard functionality
            function copyToClipboard() {
                resultOutput.select();
                document.execCommand('copy');
                
                // Show toast notification
                copyToast.style.display = 'block';
                setTimeout(() => {
                    copyToast.style.display = 'none';
                }, 2000);
            }
            
            // Event listeners
            textInput.addEventListener('input', function() {
                updateCounts();
                if (operationSelect.value) {
                    livePreview();
                }
            });
            
            operationSelect.addEventListener('change', function() {
                toggleSeparatorInput();
                if (textInput.value) {
                    livePreview();
                }
            });
            
            separatorInput.addEventListener('input', function() {
                if (textInput.value && operationSelect.value) {
                    livePreview();
                }
            });
            
            copyBtn.addEventListener('click', copyToClipboard);
            
            // Initialize
            updateCounts();
            toggleSeparatorInput();
        });
    </script>
    
    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "Text Formatter",
  "url": "https://infinitytoolspace.com/tools/formatter",
  "description": "Online text formatter to clean and beautify your content. Remove extra spaces, fix line breaks, and structure text properly.",
  "applicationCategory": "Utility",
  "operatingSystem": "All",
  "browserRequirements": "Works on modern browsers",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgso1jKWZgEPmkVK97-_8DTJwRJxPSDkF0RPBa5setQaBRWrLwt5oyKb0gzIHkcqmcEYnw6EhwerU_K2dlmwOM8LLyb13ddcYazqyOEpASG0z-qD6gigkPXnaRLPCQQHL7arYIT8wH_9d2E48CYQfiYUNCpuBSzcWm_w7aCQSrHHTc7fKD3Uf_QBQFln9s/s16000/formatter_image.jpeg"
}
</script>

</body>
</html>