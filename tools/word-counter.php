<?php
// PHP variables for SEO
$page_title = "Free Word Counter & Text Analysis Tool | Advanced Text Analytics";
$meta_description = "Comprehensive text analysis with word counting, character statistics, reading time, typing speed, keyword density, and case conversion. Completely free with instant results.";
$keywords = "word counter, character counter, sentence counter, paragraph counter, reading time calculator, typing speed, keyword density, case converter, word frequency, text analysis";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
            --light-text: #ffffff;
            --border-radius: 12px;
            --box-shadow: 0 8px 15px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }
        
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
        }
        
        .header-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--light-text);
            padding: 2.5rem 1rem;
            border-bottom-left-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
        }
        
        .main-container {
            max-width: 900px;
            margin: 2rem auto;
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            background: white;
            overflow: hidden;
        }
        
        #text-input {
            min-height: 220px;
            resize: vertical;
            border: 2px solid #e0e0e0;
            transition: var(--transition);
            border-radius: 8px;
            padding: 1rem;
            font-size: 1rem;
        }
        
        #text-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        .stat-box {
            background: var(--light-bg);
            border-radius: 8px;
            padding: 1.25rem 1rem;
            margin: 0.5rem;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            height: 100%;
        }
        
        .stat-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 12px rgba(0,0,0,0.1);
        }
        
        .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .feature-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--box-shadow);
        }
        
        .feature-title {
            font-size: 1.25rem;
            color: var(--dark-text);
            margin-bottom: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .feature-title i {
            margin-right: 0.75rem;
            color: var(--primary-color);
        }
        
        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            transition: var(--transition);
            font-weight: 500;
        }
        
        .btn-custom:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        
        .btn-outline-custom {
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            background-color: transparent;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            transition: var(--transition);
            font-weight: 500;
        }
        
        .btn-outline-custom:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .case-btn {
            margin: 0.25rem;
            flex-grow: 1;
            font-size: 0.9rem;
        }
        
        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }
        
        .nav-tabs .nav-link:hover {
            color: var(--primary-color);
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 3px solid var(--primary-color);
            background: transparent;
        }
        
        .word-cloud-container {
            height: 250px;
            position: relative;
            margin-top: 1rem;
        }
        
        .keyword-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .keyword-item:last-child {
            border-bottom: none;
        }
        
        .badge-frequency {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
        }
        
        .typing-speed-meter {
            height: 8px;
            border-radius: 4px;
            background-color: #e9ecef;
            margin: 1rem 0;
            overflow: hidden;
        }
        
        .typing-speed-progress {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            width: 0%;
            transition: width 0.5s ease;
        }
        
        .highlight-word {
            background-color: rgba(67, 97, 238, 0.15);
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            margin: 0 0.2rem;
            display: inline-block;
        }
        
        @media (max-width: 768px) {
            .main-container {
                margin: 1rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .feature-card {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <header class="header-gradient py-4">
        <div class="container">
            <h1 class="text-center fw-bold mb-2">TextAnalytics - Infinitytoolspace</h1>
            <p class="lead text-center mb-0 opacity-90">Advanced word counter & text analysis tool</p>
        </div>
    </header>

    <main class="main-container mt-n4">
        <div class="p-4">
            <div class="mb-4">
                <textarea id="text-input" class="form-control shadow-sm" 
                          placeholder="Start typing or paste your text here for instant analysis..." 
                          autofocus></textarea>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div id="typing-speed-display" class="small text-muted">
                        Typing speed: <span id="wpm">0</span> WPM
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-outline-custom me-2" onclick="copyText()">
                            <i class="fas fa-copy me-1"></i> Copy
                        </button>
                        <button class="btn btn-outline-danger" onclick="clearText()">
                            <i class="fas fa-trash-alt me-1"></i> Clear
                        </button>
                    </div>
                </div>
                <div class="typing-speed-meter mt-2">
                    <div class="typing-speed-progress" id="speed-progress"></div>
                </div>
            </div>
            
            <div class="row g-2">
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="stat-number" id="word-count">0</div>
                        <div class="stat-label">Words</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="stat-number" id="char-count">0</div>
                        <div class="stat-label">Characters</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="stat-number" id="char-no-space">0</div>
                        <div class="stat-label">Chars (no spaces)</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="stat-number" id="unique-word-count">0</div>
                        <div class="stat-label">Unique Words</div>
                    </div>
                </div>
            </div>
            
            <div class="row g-2 mt-1">
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="stat-number" id="sentence-count">0</div>
                        <div class="stat-label">Sentences</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="stat-number" id="paragraph-count">0</div>
                        <div class="stat-label">Paragraphs</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="stat-number" id="reading-time">0</div>
                        <div class="stat-label">Minutes Read</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="stat-number" id="whitespace-count">0</div>
                        <div class="stat-label">Whitespace</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Features Section -->
        <div class="px-4 pb-4">
            <ul class="nav nav-tabs mb-3" id="featureTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="case-tab" data-bs-toggle="tab" data-bs-target="#case" type="button" role="tab">
                        <i class="fas fa-font me-1"></i> Case Converter
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="keywords-tab" data-bs-toggle="tab" data-bs-target="#keywords" type="button" role="tab">
                        <i class="fas fa-chart-bar me-1"></i> Keyword Analysis
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">
                        <i class="fas fa-search me-1"></i> Text Details
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="featureTabsContent">
                <!-- Case Converter Tab -->
                <div class="tab-pane fade show active" id="case" role="tabpanel" aria-labelledby="case-tab">
                    <div class="feature-card">
                        <h3 class="feature-title"><i class="fas fa-text-height"></i>Case Converter</h3>
                        <div class="d-flex flex-wrap">
                            <button class="btn btn-outline-custom case-btn" onclick="convertCase('upper')">
                                UPPERCASE
                            </button>
                            <button class="btn btn-outline-custom case-btn" onclick="convertCase('lower')">
                                lowercase
                            </button>
                            <button class="btn btn-outline-custom case-btn" onclick="convertCase('title')">
                                Title Case
                            </button>
                            <button class="btn btn-outline-custom case-btn" onclick="convertCase('sentence')">
                                Sentence case
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Keyword Analysis Tab -->
                <div class="tab-pane fade" id="keywords" role="tabpanel" aria-labelledby="keywords-tab">
                    <div class="feature-card">
                        <h3 class="feature-title"><i class="fas fa-chart-pie"></i>Keyword Density</h3>
                        <div id="keyword-list" class="mb-3">
                            <div class="text-muted text-center py-4">
                                Enter text to analyze keyword density
                            </div>
                        </div>
                        <div class="word-cloud-container border rounded p-2 bg-light">
                        <div id="word-cloud" class="p-3 d-flex flex-wrap justify-content-center align-items-center">
                                <div class="text-muted">Enter text to generate word cloud</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Text Details Tab -->
                <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <div class="feature-card">
                        <h3 class="feature-title"><i class="fas fa-info-circle"></i>Text Details</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Special Characters
                                        <span class="badge bg-primary rounded-pill" id="special-char-count">0</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Punctuation
                                        <span class="badge bg-primary rounded-pill" id="punctuation-count">0</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Longest Word
                                        <span class="highlight-word" id="longest-word">-</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Spaces
                                        <span class="badge bg-primary rounded-pill" id="space-count">0</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Line Breaks
                                        <span class="badge bg-primary rounded-pill" id="linebreak-count">0</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Shortest Word
                                        <span class="highlight-word" id="shortest-word">-</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- SEO Content Section -->
    <section class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm p-4">
                    <h2 class="h4 mb-3">Advanced Text Analysis Tool</h2>
                    <p>Our comprehensive text analysis tool provides instant, accurate metrics for your content. Perfect for writers, students, and professionals who need detailed text analytics. This tool helps you:</p>
                    <ul>
                        <li>Count words, characters, sentences, and paragraphs in real-time</li>
                        <li>Analyze keyword density and discover frequent terms</li>
                        <li>Measure typing speed to improve productivity</li>
                        <li>Identify unique words and special characters</li>
                        <li>Convert text cases for proper formatting</li>
                        <li>Estimate reading time for better content planning</li>
                    </ul>
                    <p class="mb-0">Supports all text formats including essays, articles, blog posts, and social media content. Our mobile-friendly design works perfectly on all devices.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        const textInput = document.getElementById('text-input');
        const counters = {
            word: document.getElementById('word-count'),
            char: document.getElementById('char-count'),
            charNoSpace: document.getElementById('char-no-space'),
            paragraph: document.getElementById('paragraph-count'),
            sentence: document.getElementById('sentence-count'),
            readingTime: document.getElementById('reading-time'),
            uniqueWords: document.getElementById('unique-word-count'),
            whitespace: document.getElementById('whitespace-count'),
            specialChar: document.getElementById('special-char-count'),
            punctuation: document.getElementById('punctuation-count'),
            spaces: document.getElementById('space-count'),
            lineBreaks: document.getElementById('linebreak-count'),
            longestWord: document.getElementById('longest-word'),
            shortestWord: document.getElementById('shortest-word')
        };

        // Typing speed variables
        let typingTimer;
        let lastTypingTime = 0;
        let characterTyped = 0;
        let currentWPM = 0;

        textInput.addEventListener('input', function() {
            updateCounters();
            updateTypingSpeed();
        });

        function updateCounters() {
            const text = textInput.value;
            
            // Word Count
            const words = text.trim().split(/\s+/).filter(word => word.length > 0);
            counters.word.textContent = text.trim() ? words.length : 0;
            
            // Character Counts
            counters.char.textContent = text.length;
            counters.charNoSpace.textContent = text.replace(/\s/g, '').length;
            
            // Paragraph Count
            counters.paragraph.textContent = text.trim() ? 
                text.split(/\n+/).filter(p => p.trim()).length : 0;
            
            // Sentence Count - improved regex for better accuracy
            counters.sentence.textContent = text.trim() ? 
                text.split(/[.!?]+(?=\s+|$)/).filter(s => s.trim()).length : 0;
            
            // Reading Time (200 words/minute)
            const minutes = Math.max(1, Math.ceil(words.length / 200));
            counters.readingTime.textContent = words.length > 0 ? minutes : 0;
            
            // Unique Word Count
            const uniqueWords = new Set(words.map(word => word.toLowerCase()));
            counters.uniqueWords.textContent = uniqueWords.size;
            
            // Whitespace Count
            counters.whitespace.textContent = (text.match(/\s/g) || []).length;
            
            // Special Characters & Punctuation
            const specialChars = (text.match(/[^a-zA-Z0-9\s]/g) || []).length;
            counters.specialChar.textContent = specialChars;
            
            const punctuation = (text.match(/[.,!?;:]/g) || []).length;
            counters.punctuation.textContent = punctuation;
            
            // Spaces & Line Breaks
            counters.spaces.textContent = (text.match(/ /g) || []).length;
            counters.lineBreaks.textContent = (text.match(/\n/g) || []).length;
            
            // Longest & Shortest Words
            if (words.length > 0) {
                // Filter out empty strings and sort by length
                const sortedWords = [...words].filter(word => word.replace(/[^\w]/g, '').length > 0)
                                             .sort((a, b) => b.length - a.length);
                
                if (sortedWords.length > 0) {
                    counters.longestWord.textContent = sortedWords[0];
                    counters.shortestWord.textContent = sortedWords[sortedWords.length - 1];
                } else {
                    counters.longestWord.textContent = "-";
                    counters.shortestWord.textContent = "-";
                }
            } else {
                counters.longestWord.textContent = "-";
                counters.shortestWord.textContent = "-";
            }
            
            // Update Keyword Density
            updateKeywordDensity(words);
            
            // Update Word Cloud
            updateWordCloud(words);
        }

        function updateTypingSpeed() {
            const now = new Date().getTime();
            
            if (lastTypingTime === 0) {
                lastTypingTime = now;
                characterTyped = textInput.value.length;
                return;
            }
            
            clearTimeout(typingTimer);
            
            typingTimer = setTimeout(function() {
                const timeElapsed = (now - lastTypingTime) / 1000 / 60; // in minutes
                const charTyped = textInput.value.length - characterTyped;
                
                if (timeElapsed > 0 && charTyped > 0) {
                    // Assuming average word length of 5 characters
                    const wordsTyped = charTyped / 5;
                    currentWPM = Math.round(wordsTyped / timeElapsed);
                    
                    // Cap at a reasonable maximum
                    currentWPM = Math.min(currentWPM, 200);
                    
                    document.getElementById('wpm').textContent = currentWPM;
                    document.getElementById('speed-progress').style.width = `${(currentWPM / 200) * 100}%`;
                }
                
                lastTypingTime = now;
                characterTyped = textInput.value.length;
            }, 2000);
        }

        function updateKeywordDensity(words) {
            const keywordList = document.getElementById('keyword-list');
            
            // Skip if no words
            if (words.length === 0) {
                keywordList.innerHTML = '<div class="text-muted text-center py-4">Enter text to analyze keyword density</div>';
                return;
            }
            
            // Count word frequency
            const wordFrequency = {};
            words.forEach(word => {
                // Convert to lowercase and remove punctuation
                const cleanWord = word.toLowerCase().replace(/[^\w\s]|_/g, "");
                if (cleanWord && cleanWord.length > 2) {  // Ignore very short words
                    wordFrequency[cleanWord] = (wordFrequency[cleanWord] || 0) + 1;
                }
            });
            
            // Sort by frequency
            const sortedWords = Object.entries(wordFrequency)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 10);  // Get top 10
            
            // Create HTML
            if (sortedWords.length === 0) {
                keywordList.innerHTML = '<div class="text-muted text-center py-4">No significant keywords found</div>';
                return;
            }
            
            let html = '';
            sortedWords.forEach(([word, count]) => {
                const percentage = ((count / words.length) * 100).toFixed(1);
                html += `
                    <div class="keyword-item">
                        <span class="keyword-word">${word}</span>
                        <span class="badge-frequency">${count} (${percentage}%)</span>
                    </div>
                `;
            });
            
            keywordList.innerHTML = html;
        }

        function updateWordCloud(words) {
            const wordCloud = document.getElementById('word-cloud');
            
            // Skip if no words
            if (words.length === 0) {
                wordCloud.innerHTML = '<div class="text-muted">Enter text to generate word cloud</div>';
                return;
            }
            
            // Count word frequency
            const wordFrequency = {};
            words.forEach(word => {
                // Convert to lowercase and remove punctuation
                const cleanWord = word.toLowerCase().replace(/[^\w\s]|_/g, "");
                if (cleanWord && cleanWord.length > 2) {  // Ignore very short words
                    wordFrequency[cleanWord] = (wordFrequency[cleanWord] || 0) + 1;
                }
            });
            
            // Sort by frequency
            const sortedWords = Object.entries(wordFrequency)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 30);  // Get top 30
            
            // Create HTML
            if (sortedWords.length === 0) {
                wordCloud.innerHTML = '<div class="text-muted">No significant words found for cloud visualization</div>';
                return;
            }
            
            // Find max and min frequency
            const maxFreq = sortedWords[0][1];
            const minFreq = sortedWords[sortedWords.length - 1][1];
            
            let html = '';
            sortedWords.forEach(([word, count]) => {
                // Scale font size between 1 and 3rem based on frequency
                const fontSize = 1 + (count - minFreq) / (maxFreq - minFreq) * 2;
                // Vary color based on frequency
                const opacity = 0.5 + (count - minFreq) / (maxFreq - minFreq) * 0.5;
                
                html += `
                    <span class="mx-1 my-1" style="font-size: ${fontSize}rem; color: rgba(67, 97, 238, ${opacity});">
                        ${word}
                    </span>
                `;
            });
            
            wordCloud.innerHTML = html;
        }

        function copyText() {
            textInput.select();
            document.execCommand('copy');
            
            // Visual feedback
            const originalBorder = textInput.style.border;
            textInput.style.border = '2px solid #4cc9f0';
            setTimeout(() => {
                textInput.style.border = originalBorder;
            }, 500);
        }

        function clearText() {
            textInput.value = '';
            updateCounters();
            lastTypingTime = 0;
            characterTyped = 0;
            currentWPM = 0;
            document.getElementById('wpm').textContent = '0';
            document.getElementById('speed-progress').style.width = '0%';
        }

        function convertCase(caseType) {
            const text = textInput.value;
            
            if (!text.trim()) return;
            
            switch(caseType) {
                case 'upper':
                    textInput.value = text.toUpperCase();
                    break;
                case 'lower':
                    textInput.value = text.toLowerCase();
                    break;
                case 'title':
                    textInput.value = text.replace(/\w\S*/g, function(txt) {
                        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                    });
                    break;
                case 'sentence':
                    textInput.value = text.toLowerCase().replace(/(^\s*\w|[.!?]\s*\w)/g, function(txt) {
                        return txt.toUpperCase();
                    });
                    break;
            }
            
            // Update counters after conversion
            updateCounters();
        }

        // Initial call to set all counters to 0
        updateCounters();
    </script>

    <!-- Structured Data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "TextAnalytics - Word & Character Counter",
        "description": "<?php echo $meta_description; ?>",
        "applicationCategory": "WritingApplication",
        "operatingSystem": "Web",
        "offers": {
            "@type": "Offer",
            "price": "0"
        }
    }
    </script>
</body>
</html>