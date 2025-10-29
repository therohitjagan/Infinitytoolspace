<?php
$page_title = "Color Palette Generator | Infinitytoolspace";
$meta_description = "Generate stunning color palettes for your designs. Create, customize, and export color schemes instantly with our free online tool. Perfect for web designers and developers!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="description" content="<?= $meta_description ?>">
    <meta name="keywords" content="color palette generator, create color palette, generate color scheme, color combinations, hex color palette, rgb palette, design color tool, web design colors">
    <link rel="canonical" href="https://infinitytoolspace.com/tools/palette" />
    
    <meta property="og:title" content="Color Palette Generator - Create Beautiful Color Schemes" />
<meta property="og:description" content="Generate color palettes from scratch or images. Get perfect color combos for web, design, branding, and UI/UX projects." />
<meta property="og:url" content="https://infinitytoolspace.com/tools/palette" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiEgbhKHmX_jdcgOIIEWTdekmXqhqSXFjeqE7VTapNaO3ieOzl0KlGe1dYPT7OEgLOjqnYIM8DrMmIUzsvoskEixvPnkC8Sj0l7d_nInuFvmonodv8E_IDHZyAGrcCNxcWiWJ0aaExcE30mfDRSODKv0fMDHuwEHOSUaMNlTqjoRSPwnfJyNtx_geDzgHY/s16000/Color%20Palette%20Generator.jpg" />


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
            --transition-time: 0.3s;
            --primary-color: #6c5ce7;
            --secondary-color: #a29bfe;
            --accent-color: #fd79a8;
            --light-bg: #f8f9fa;
            --dark-bg: #2d3436;
        }

        body {
            background: var(--light-bg);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .app-header {
            padding: 2rem 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 0 0 30px 30px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px rgba(108, 92, 231, 0.2);
        }

        .app-title {
            font-weight: 800;
            font-size: 2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .color-block {
            height: 300px;
            transition: all var(--transition-time) ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .color-block:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .color-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 1rem;
            backdrop-filter: blur(5px);
        }

        .color-formats {
            display: flex;
            justify-content: space-between;
            margin-top: 0.5rem;
        }

        .format-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            border-radius: 5px;
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
            transition: all 0.2s ease;
        }

        .format-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.05);
        }

        .lock-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255,255,255,0.2);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .lock-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        .lock-btn.locked {
            background: rgba(255,255,255,0.9);
            color: #000;
        }

        .feature-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .generate-btn {
            padding: 1rem 2rem;
            font-size: 1.2rem;
            transition: transform 0.2s ease;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
        }

        .generate-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(108, 92, 231, 0.4);
        }

        .harmony-btn {
            border-radius: 50px;
            padding: 0.5rem 1rem;
            margin: 0.3rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .harmony-btn:hover {
            transform: scale(1.05);
        }

        .custom-input-group {
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .custom-input {
            border: none;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
        }

        .custom-input:focus {
            outline: none;
            box-shadow: none;
        }

        .control-panel {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }

        .export-btn {
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
            margin: 0.3rem;
            transition: all 0.2s ease;
            background: white;
            color: #333;
            border: 1px solid #ddd;
        }

        .export-btn:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
        }

        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-upload input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            cursor: pointer;
            display: block;
        }
        
        .gradient-preview {
            height: 100px;
            border-radius: 15px;
            overflow: hidden;
            margin: 1rem 0;
        }

        .share-link {
            padding: 0.8rem;
            border-radius: 10px;
            background: #f8f9fa;
            font-size: 0.9rem;
            margin: 1rem 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 100%;
        }

        .copied-alert {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            display: none;
            border-radius: 10px;
            padding: 1rem 2rem;
            background: var(--primary-color);
            color: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }

        .color-tab {
            cursor: pointer;
            padding: 0.5rem 1rem;
            text-align: center;
            font-weight: 600;
            transition: all 0.2s ease;
            border-radius: 10px 10px 0 0;
        }

        .color-tab.active {
            background: white;
            color: var(--primary-color);
        }

        .tab-content {
            background: white;
            padding: 2rem;
            border-radius: 0 0 15px 15px;
        }

        @media (max-width: 768px) {
            .app-title {
                font-size: 2rem;
            }
            
            .color-block {
                height: 250px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <header class="app-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="app-title">🎨 Color Palette Generator - Infinitytoolspace</h1>
                    <p class="lead">Create stunning color schemes for your designs instantly</p>
                </div>
                <!--<div class="col-md-4 text-end d-none d-md-block">-->
                <!--    <img src="https://via.placeholder.com/150x150" alt="Color Palette Icon" class="img-fluid" style="max-width: 150px;">-->
                <!--</div>-->
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Control Panel -->
        <div class="control-panel">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="section-title">Color Harmony</h2>
                    <div class="harmony-buttons">
                        <button class="btn harmony-btn active" data-harmony="random">Random</button>
                        <button class="btn harmony-btn" data-harmony="monochromatic">Monochromatic</button>
                        <button class="btn harmony-btn" data-harmony="analogous">Analogous</button>
                        <button class="btn harmony-btn" data-harmony="complementary">Complementary</button>
                        <button class="btn harmony-btn" data-harmony="split">Split Complementary</button>
                        <button class="btn harmony-btn" data-harmony="triadic">Triadic</button>
                        <button class="btn harmony-btn" data-harmony="tetradic">Tetradic</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="section-title">Custom Color</h2>
                    <div class="input-group custom-input-group mb-3">
                        <input type="text" class="form-control custom-input" id="customColorInput" 
                            placeholder="Enter HEX, RGB, or HSL color value (e.g. #6c5ce7)">
                        <button class="btn btn-primary" id="customColorBtn">Generate</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Color Palette -->
        <div class="row g-4 mb-4" id="paletteContainer">
            <!-- Color blocks will be inserted here -->
        </div>

        <div class="text-center mb-5">
            <button class="btn btn-primary generate-btn" onclick="generatePalette()">
                🔄 Generate New Palette
            </button>
        </div>
        
        <!-- Features Tabs -->
        <div class="mb-5">
            <div class="d-flex mb-0 bg-light rounded-top">
                <div class="color-tab active" data-tab="share">Share Palette</div>
                <div class="color-tab" data-tab="export">Export Options</div>
                <div class="color-tab" data-tab="gradient">Gradient Generator</div>
                <div class="color-tab" data-tab="image">Image to Palette</div>
            </div>
            
            <div class="tab-content">
                <!-- Share Palette Tab -->
                <div class="tab-pane active" id="shareTab">
                    <h3 class="h5 mb-3">Share Your Palette</h3>
                    <p>Generate a unique URL to share this color palette with others.</p>
                    <button class="btn btn-primary mb-3" id="generateShareLink">Generate Share Link</button>
                    <div id="shareLinkContainer" style="display: none;">
                        <input type="text" class="share-link" id="shareLink" readonly>
                        <button class="btn btn-outline-primary btn-sm" onclick="copyToClipboard(document.getElementById('shareLink').value)">
                            <i class="fas fa-copy"></i> Copy Link
                        </button>
                    </div>
                </div>
                
                <!-- Export Options Tab -->
                <div class="tab-pane" id="exportTab" style="display: none;">
                    <h3 class="h5 mb-3">Export Your Palette</h3>
                    <p>Download your palette in different formats for easy use in your projects.</p>
                    <div class="d-flex flex-wrap">
                        <button class="export-btn" onclick="exportPalette('png')">
                            <i class="fas fa-image me-1"></i> PNG
                        </button>
                        <button class="export-btn" onclick="exportPalette('json')">
                            <i class="fas fa-code me-1"></i> JSON
                        </button>
                        <button class="export-btn" onclick="exportPalette('css')">
                            <i class="fas fa-file-code me-1"></i> CSS Variables
                        </button>
                        <button class="export-btn" onclick="exportPalette('scss')">
                            <i class="fas fa-paint-brush me-1"></i> SCSS Variables
                        </button>
                    </div>
                </div>
                
                <!-- Gradient Generator Tab -->
                <div class="tab-pane" id="gradientTab" style="display: none;">
                    <h3 class="h5 mb-3">Gradient Generator</h3>
                    <p>Create smooth gradients between colors.</p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="gradientStart" class="form-label">Start Color</label>
                            <input type="color" class="form-control form-control-color w-100" id="gradientStart" value="#6c5ce7">
                        </div>
                        <div class="col-md-6">
                            <label for="gradientEnd" class="form-label">End Color</label>
                            <input type="color" class="form-control form-control-color w-100" id="gradientEnd" value="#fd79a8">
                        </div>
                    </div>
                    <label class="form-label">Gradient Direction</label>
                    <select class="form-select mb-3" id="gradientDirection">
                        <option value="to right">Horizontal (Left to Right)</option>
                        <option value="to bottom">Vertical (Top to Bottom)</option>
                        <option value="to bottom right">Diagonal (Top Left to Bottom Right)</option>
                        <option value="to bottom left">Diagonal (Top Right to Bottom Left)</option>
                    </select>
                    <button class="btn btn-primary mb-3" onclick="generateGradient()">Generate Gradient</button>
                    <div class="gradient-preview" id="gradientPreview"></div>
                    <div id="gradientCode" class="bg-light p-3 rounded">
                        <code>background: linear-gradient(to right, #6c5ce7, #fd79a8);</code>
                    </div>
                </div>
                
                <!-- Image to Palette Tab -->
                <div class="tab-pane" id="imageTab" style="display: none;">
                    <h3 class="h5 mb-3">Extract Colors from Image</h3>
                    <p>Upload an image to extract dominant colors and create a palette.</p>
                    <div class="file-upload mb-3">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-cloud-upload-alt me-1"></i> Upload Image
                        </button>
                        <input type="file" id="imageUpload" accept="image/*">
                    </div>
                    <div id="uploadedImageContainer" style="display: none;">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <img id="uploadedImage" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                            <div class="col-md-8">
                                <p>Extracted Colors:</p>
                                <div class="d-flex flex-wrap" id="extractedColors">
                                    <!-- Extracted colors will appear here -->
                                </div>
                                <button class="btn btn-primary mt-3" id="useExtractedColors">Use These Colors</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Content -->
        <section class="seo-content mt-5">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <h2 class="h4">Create Beautiful Color Schemes Instantly</h2>
                        <p>Our free online Color Palette Generator helps designers and developers create perfect color combinations for websites, apps, and graphic designs. Generate harmonious color schemes using advanced algorithms, adjust individual colors, and export your palettes for easy use in your projects.</p>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-magic"></i>
                        </div>
                        <h3 class="h4">Why Use Our Color Palette Tool?</h3>
                        <ul>
                            <li>Instant palette generation with one click</li>
                            <li>Multiple color harmony options (Monochromatic, Analogous, Complementary, etc.)</li>
                            <li>Copy colors in HEX, RGB, and HSL formats</li>
                            <li>Extract colors from uploaded images</li>
                            <li>Create smooth gradients between colors</li>
                            <li>Share palettes with unique URLs</li>
                            <li>Export in multiple formats (PNG, JSON, CSS, SCSS)</li>
                            <li>100% free with no registration required</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        
        
    </div>

    <!-- Copied Alert -->
    <div class="copied-alert" role="alert">
        <i class="fas fa-check-circle me-2"></i> Copied to clipboard!
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script>
        const lockedColors = Array(6).fill(false);
        let currentHarmony = 'random';
        
        function generateColor() {
            return '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0');
        }

        function hexToRgb(hex) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return { r, g, b };
        }

        function rgbToHex(r, g, b) {
            return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
        }

        function rgbToHsl(r, g, b) {
            r /= 255;
            g /= 255;
            b /= 255;
            
            const max = Math.max(r, g, b);
            const min = Math.min(r, g, b);
            let h, s, l = (max + min) / 2;

            if (max === min) {
                h = s = 0; // achromatic
            } else {
                const d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                
                switch (max) {
                    case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                    case g: h = (b - r) / d + 2; break;
                    case b: h = (r - g) / d + 4; break;
                }
                
                h /= 6;
            }

            return {
                h: Math.round(h * 360),
                s: Math.round(s * 100),
                l: Math.round(l * 100)
            };
        }

        function hslToRgb(h, s, l) {
            h /= 360;
            s /= 100;
            l /= 100;
            
            let r, g, b;

            if (s === 0) {
                r = g = b = l; // achromatic
            } else {
                const hue2rgb = (p, q, t) => {
                    if (t < 0) t += 1;
                    if (t > 1) t -= 1;
                    if (t < 1/6) return p + (q - p) * 6 * t;
                    if (t < 1/2) return q;
                    if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
                    return p;
                };

                const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
                const p = 2 * l - q;
                
                r = hue2rgb(p, q, h + 1/3);
                g = hue2rgb(p, q, h);
                b = hue2rgb(p, q, h - 1/3);
            }

            return {
                r: Math.round(r * 255),
                g: Math.round(g * 255),
                b: Math.round(b * 255)
            };
        }

        function rgbToString(rgb) {
            return `rgb(${rgb.r}, ${rgb.g}, ${rgb.b})`;
        }

        function hslToString(hsl) {
            return `hsl(${hsl.h}, ${hsl.s}%, ${hsl.l}%)`;
        }

        function createColorBlock(color, index) {
            const rgb = hexToRgb(color);
            const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
            
            return `
                <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                    <div class="color-block" style="background: ${color}" data-color="${color}">
                        <button class="lock-btn ${lockedColors[index] ? 'locked' : ''}" 
                                onclick="toggleLock(${index}, event)">
                            <i class="fas fa-${lockedColors[index] ? 'lock' : 'lock-open'}"></i>
                        </button>
                        <div class="color-info">
                            <div class="text-center fw-bold">${color}</div>
                            <div class="color-formats">
                                <button class="format-btn" onclick="copyToClipboard('${color}', event)">
                                    <i class="fas fa-copy me-1"></i> HEX
                                </button>
                                <button class="format-btn" onclick="copyToClipboard('${rgbToString(rgb)}', event)">
                                    <i class="fas fa-copy me-1"></i> RGB
                                </button>
                                <button class="format-btn" onclick="copyToClipboard('${hslToString(hsl)}', event)">
                                    <i class="fas fa-copy me-1"></i> HSL
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function generateMonochromaticPalette(baseColor) {
            const rgb = hexToRgb(baseColor);
            const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
            const palette = [];
            
            // Keep the base color
            palette.push(baseColor);
            
            // Generate 5 variations with different lightness
            for (let i = 1; i < 6; i++) {
                let newHsl = {...hsl};
                
                // Vary the lightness
                newHsl.l = Math.max(10, Math.min(90, hsl.l - 30 + i * 12));
                
                // Convert back to RGB and then to HEX
                const newRgb = hslToRgb(newHsl.h, newHsl.s, newHsl.l);
                palette.push(rgbToHex(newRgb.r, newRgb.g, newRgb.b));
            }
            
            return palette;
        }

        function generateAnalogousPalette(baseColor) {
            const rgb = hexToRgb(baseColor);
            const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
            const palette = [];
            
            // Generate 6 colors with hues spaced 30 degrees apart
            for (let i = 0; i < 6; i++) {
                let newHsl = {...hsl};
                
                // Shift the hue by -60 to +60 degrees
                newHsl.h = (hsl.h - 60 + i * 24 + 360) % 360;
                
                // Convert back to RGB and then to HEX
                const newRgb = hslToRgb(newHsl.h, newHsl.s, newHsl.l);
                palette.push(rgbToHex(newRgb.r, newRgb.g, newRgb.b));
            }
            
            return palette;
        }

        function generateComplementaryPalette(baseColor) {
            const rgb = hexToRgb(baseColor);
            const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
            const palette = [];
            
            // Generate 3 shades of the base color
            for (let i = 0; i < 3; i++) {
                let newHsl = {...hsl};
                newHsl.l = Math.max(20, Math.min(80, hsl.l - 20 + i * 20));
                const newRgb = hslToRgb(newHsl.h, newHsl.s, newHsl.l);
                palette.push(rgbToHex(newRgb.r, newRgb.g, newRgb.b));
            }
            
            // Generate 3 shades of the complementary color
            const compHue = (hsl.h + 180) % 360;
            for (let i = 0; i < 3; i++) {
                let newHsl = {...hsl, h: compHue};
                newHsl.l = Math.max(20, Math.min(80, hsl.l - 20 + i * 20));
                const newRgb = hslToRgb(newHsl.h, newHsl.s, newHsl.l);
                palette.push(rgbToHex(newRgb.r, newRgb.g, newRgb.b));
            }
            
            return palette;
        }

        function generateSplitComplementaryPalette(baseColor) {
            const rgb = hexToRgb(baseColor);
            const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
            const palette = [];
            
            // Base color and variations
            for (let i = 0; i < 2; i++) {
                let newHsl = {...hsl};
                newHsl.l = Math.max(20, Math.min(80, hsl.l - 10 + i * 20));
                const newRgb = hslToRgb(newHsl.h, newHsl.s, newHsl.l);
                palette.push(rgbToHex(newRgb.r, newRgb.g, newRgb.b));
            }
            
            // Split complementary colors (150 and 210 degrees from base)
            const split1 = (hsl.h + 150) % 360;
            const split2 = (hsl.h + 210) % 360;
            
            for (let i = 0; i < 2; i++) {
                let newHsl = {...hsl, h: split2};
                newHsl.l = Math.max(20, Math.min(80, hsl.l - 10 + i * 20));
                const newRgb = hslToRgb(newHsl.h, newHsl.s, newHsl.l);
                palette.push(rgbToHex(newRgb.r, newRgb.g, newRgb.b));
            }
            
            return palette;
        }

        function generateTriadicPalette(baseColor) {
            const rgb = hexToRgb(baseColor);
            const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
            const palette = [];
            
            // Generate 2 variations of each triadic color (base + 120° + 240°)
            for (let i = 0; i < 3; i++) {
                let triadicHue = (hsl.h + i * 120) % 360;
                
                for (let j = 0; j < 2; j++) {
                    let newHsl = {...hsl, h: triadicHue};
                    newHsl.l = Math.max(30, Math.min(70, hsl.l - 10 + j * 20));
                    const newRgb = hslToRgb(newHsl.h, newHsl.s, newHsl.l);
                    palette.push(rgbToHex(newRgb.r, newRgb.g, newRgb.b));
                }
            }
            
            return palette;
        }

        function generateTetradicPalette(baseColor) {
            const rgb = hexToRgb(baseColor);
            const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
            const palette = [];
            
            // Generate colors at 0°, 90°, 180°, and 270° from the base hue
            for (let i = 0; i < 4; i++) {
                let tetradicHue = (hsl.h + i * 90) % 360;
                
                // Generate a lighter and darker version of each hue
                for (let j = 0; j < 2; j++) {
                    let newHsl = {...hsl, h: tetradicHue};
                    if (j === 0) {
                        newHsl.l = Math.min(85, hsl.l + 15);
                    } else {
                        newHsl.l = Math.max(25, hsl.l - 15);
                    }
                    
                    const newRgb = hslToRgb(newHsl.h, newHsl.s, newHsl.l);
                    palette.push(rgbToHex(newRgb.r, newRgb.g, newRgb.b));
                }
            }
            
            // Only return the first 6 if we have more
            return palette.slice(0, 6);
        }

        function getHarmonyPalette(baseColor) {
            switch(currentHarmony) {
                case 'monochromatic':
                    return generateMonochromaticPalette(baseColor);
                case 'analogous':
                    return generateAnalogousPalette(baseColor);
                case 'complementary':
                    return generateComplementaryPalette(baseColor);
                case 'split':
                    return generateSplitComplementaryPalette(baseColor);
                case 'triadic':
                    return generateTriadicPalette(baseColor);
                case 'tetradic':
                    return generateTetradicPalette(baseColor);
                default:
                    return Array(6).fill().map(() => generateColor());
            }
        }

        function generatePalette() {
            const paletteContainer = document.getElementById('paletteContainer');
            let html = '';
            let palette = [];
            
            // Handle random palette generation
            if (currentHarmony === 'random') {
                palette = Array(6).fill().map((_, i) => {
                    return lockedColors[i] ? 
                        paletteContainer.children[i]?.querySelector('.color-block')?.dataset.color || generateColor() :
                        generateColor();
                });
            } 
            // Handle other harmony types
            else {
                // Find a base color (either the first locked color or generate a new one)
                let baseColor = null;
                const lockedIndices = [];
                
                for (let i = 0; i < 6; i++) {
                    if (lockedColors[i]) {
                        lockedIndices.push(i);
                        if (baseColor === null) {
                            baseColor = paletteContainer.children[i]?.querySelector('.color-block')?.dataset.color;
                        }
                    }
                }
                
                if (baseColor === null) {
                    baseColor = generateColor();
                }
                
                // Generate the harmony palette
                const harmonyPalette = getHarmonyPalette(baseColor);
                
                // Combine locked colors with the harmony palette
                palette = Array(6).fill().map((_, i) => {
                    if (lockedColors[i]) {
                        return paletteContainer.children[i]?.querySelector('.color-block')?.dataset.color || harmonyPalette[i];
                    } else {
                        return harmonyPalette[i];
                    }
                });
            }
            
            // Create the HTML
            for(let i = 0; i < 6; i++) {
                html += createColorBlock(palette[i], i);
            }
            
            paletteContainer.innerHTML = html;
            
            // Update sharing link
            updateShareLink();
        }

        function toggleLock(index, event) {
            event.stopPropagation();
            lockedColors[index] = !lockedColors[index];
            
            // Update the lock button without regenerating the palette
            const lockBtn = event.target.closest('.lock-btn');
            lockBtn.classList.toggle('locked');
            lockBtn.innerHTML = lockedColors[index] ? 
                '<i class="fas fa-lock"></i>' : 
                '<i class="fas fa-lock-open"></i>';
        }

        function copyToClipboard(text, event) {
            if (event) event.stopPropagation();
            navigator.clipboard.writeText(text);
            showCopiedAlert(text);
        }

        function showCopiedAlert(text) {
            const alert = document.querySelector('.copied-alert');
            alert.textContent = `Copied to clipboard: ${text}`;
            alert.style.display = 'block';
            setTimeout(() => alert.style.display = 'none', 2000);
        }

        function generateGradient() {
            const startColor = document.getElementById('gradientStart').value;
            const endColor = document.getElementById('gradientEnd').value;
            const direction = document.getElementById('gradientDirection').value;
            
            const gradientCSS = `linear-gradient(${direction}, ${startColor}, ${endColor})`;
            const preview = document.getElementById('gradientPreview');
            
            preview.style.background = gradientCSS;
            document.getElementById('gradientCode').innerHTML = `<code>background: ${gradientCSS};</code>`;
        }

        function extractColorsFromImage(imageElement) {
            // For a real application, you would use a color quantization algorithm
            // This is a simplified example that samples pixels from the image
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // Scale the image to reduce processing
            const maxSize = 100;
            const ratio = Math.min(maxSize / imageElement.width, maxSize / imageElement.height);
            canvas.width = imageElement.width * ratio;
            canvas.height = imageElement.height * ratio;
            
            // Draw the image
            ctx.drawImage(imageElement, 0, 0, canvas.width, canvas.height);
            
            // Sample pixels
            const colors = [];
            const pixelData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
            
            // Sample points in a grid
            const sampleSize = 10;
            for (let y = 0; y < canvas.height; y += sampleSize) {
                for (let x = 0; x < canvas.width; x += sampleSize) {
                    const i = (y * canvas.width + x) * 4;
                    const r = pixelData[i];
                    const g = pixelData[i + 1];
                    const b = pixelData[i + 2];
                    
                    colors.push(rgbToHex(r, g, b));
                }
            }
            
            // Deduplicate and get the most common colors
            const colorCounts = colors.reduce((acc, color) => {
                acc[color] = (acc[color] || 0) + 1;
                return acc;
            }, {});
            
            // Sort by frequency and take top 6
            return Object.entries(colorCounts)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 6)
                .map(entry => entry[0]);
        }

        function updateShareLink() {
            // Create a URL with the current palette colors
            const colors = Array.from(document.querySelectorAll('.color-block'))
                .map(block => block.dataset.color.replace('#', ''));
            
            const shareUrl = `${window.location.origin}${window.location.pathname}?palette=${colors.join(',')}`;
            
            // Update the share link input if visible
            const shareLinkElement = document.getElementById('shareLink');
            if (shareLinkElement) {
                shareLinkElement.value = shareUrl;
            }
            
            return shareUrl;
        }

        function exportPalette(format) {
            const colors = Array.from(document.querySelectorAll('.color-block'))
                .map(block => block.dataset.color);
            
            switch(format) {
                case 'png':
                    exportAsPNG(colors);
                    break;
                case 'json':
                    exportAsJSON(colors);
                    break;
                case 'css':
                    exportAsCSS(colors);
                    break;
                case 'scss':
                    exportAsSCSS(colors);
                    break;
            }
        }

        function exportAsPNG(colors) {
            // Create a canvas to render the palette
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            canvas.width = 600;
            canvas.height = 100;
            
            // Draw each color as a rectangle
            const blockWidth = canvas.width / colors.length;
            
            colors.forEach((color, index) => {
                ctx.fillStyle = color;
                ctx.fillRect(index * blockWidth, 0, blockWidth, canvas.height);
                
                // Add color code
                ctx.fillStyle = "#fff";
                ctx.font = "12px Arial";
                ctx.textAlign = "center";
                ctx.fillText(color, (index * blockWidth) + (blockWidth / 2), canvas.height / 2);
            });
            
            // Convert canvas to PNG and download
            const link = document.createElement('a');
            link.download = 'color-palette.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        }

        function exportAsJSON(colors) {
            const paletteData = {
                name: "My Color Palette",
                createdAt: new Date().toISOString(),
                colors: colors.map(color => {
                    const rgb = hexToRgb(color);
                    const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
                    
                    return {
                        hex: color,
                        rgb: [rgb.r, rgb.g, rgb.b],
                        hsl: [hsl.h, hsl.s, hsl.l]
                    };
                })
            };
            
            const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(paletteData, null, 2));
            const downloadLink = document.createElement('a');
            downloadLink.href = dataStr;
            downloadLink.download = "color-palette.json";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        function exportAsCSS(colors) {
            let css = `:root {\n`;
            
            colors.forEach((color, index) => {
                css += `  --color-${index + 1}: ${color};\n`;
            });
            
            css += `}\n`;
            
            const dataStr = "data:text/css;charset=utf-8," + encodeURIComponent(css);
            const downloadLink = document.createElement('a');
            downloadLink.href = dataStr;
            downloadLink.download = "color-palette.css";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        function exportAsSCSS(colors) {
            let scss = `// Color Palette Variables\n`;
            
            colors.forEach((color, index) => {
                scss += `$color-${index + 1}: ${color};\n`;
            });
            
            const dataStr = "data:text/scss;charset=utf-8," + encodeURIComponent(scss);
            const downloadLink = document.createElement('a');
            downloadLink.href = dataStr;
            downloadLink.download = "color-palette.scss";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        // Load palette from URL if present
        function loadPaletteFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            const paletteParam = urlParams.get('palette');
            
            if (paletteParam) {
                const colors = paletteParam.split(',').map(c => `#${c}`);
                
                if (colors.length === 6) {
                    const paletteContainer = document.getElementById('paletteContainer');
                    let html = '';
                    
                    for(let i = 0; i < 6; i++) {
                        html += createColorBlock(colors[i], i);
                    }
                    
                    paletteContainer.innerHTML = html;
                    return;
                }
            }
            
            // If no palette in URL or invalid format, generate a new one
            generatePalette();
        }

        // Tab navigation
        document.querySelectorAll('.color-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Update active tab
                document.querySelectorAll('.color-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Show corresponding tab content
                document.querySelectorAll('.tab-pane').forEach(pane => pane.style.display = 'none');
                const tabId = this.dataset.tab + 'Tab';
                document.getElementById(tabId).style.display = 'block';
            });
        });

        // Handle harmony button clicks
        document.querySelectorAll('.harmony-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.harmony-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentHarmony = this.dataset.harmony;
                generatePalette();
            });
        });

        // Handle custom color input
        document.getElementById('customColorBtn').addEventListener('click', function() {
            const input = document.getElementById('customColorInput').value.trim();
            
            // Simple validation for hex color
            if (/^#[0-9A-F]{6}$/i.test(input)) {
                currentHarmony = document.querySelector('.harmony-btn.active').dataset.harmony;
                
                // If no colors are locked, use the custom color as base
                if (!lockedColors.some(lock => lock)) {
                    const paletteContainer = document.getElementById('paletteContainer');
                    const colorBlock = paletteContainer.querySelector('.color-block');
                    if (colorBlock) {
                        colorBlock.dataset.color = input;
                        colorBlock.style.background = input;
                    }
                }
                
                generatePalette();
            } else {
                alert('Please enter a valid HEX color code (e.g. #6c5ce7)');
            }
        });

        // Handle share link generation
        document.getElementById('generateShareLink').addEventListener('click', function() {
            const shareUrl = updateShareLink();
            document.getElementById('shareLinkContainer').style.display = 'block';
        });

        // Handle image upload
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    const uploadedImage = document.getElementById('uploadedImage');
                    uploadedImage.src = event.target.result;
                    
                    uploadedImage.onload = function() {
                        // Extract colors from the image
                        const extractedColors = extractColorsFromImage(uploadedImage);
                        
                        // Display the extracted colors
                        const extractedColorsContainer = document.getElementById('extractedColors');
                        extractedColorsContainer.innerHTML = '';
                        
                        extractedColors.forEach(color => {
                            const colorSwatch = document.createElement('div');
                            colorSwatch.style.backgroundColor = color;
                            colorSwatch.style.width = '40px';
                            colorSwatch.style.height = '40px';
                            colorSwatch.style.margin = '5px';
                            colorSwatch.style.borderRadius = '5px';
                            colorSwatch.dataset.color = color;
                            colorSwatch.title = color;
                            extractedColorsContainer.appendChild(colorSwatch);
                        });
                        
                        document.getElementById('uploadedImageContainer').style.display = 'block';
                    };
                };
                
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Use extracted colors
        document.getElementById('useExtractedColors').addEventListener('click', function() {
            const extractedColors = Array.from(document.querySelectorAll('#extractedColors div'))
                .map(div => div.dataset.color);
            
            if (extractedColors.length) {
                const paletteContainer = document.getElementById('paletteContainer');
                let html = '';
                
                for(let i = 0; i < Math.min(6, extractedColors.length); i++) {
                    html += createColorBlock(extractedColors[i], i);
                }
                
                // If we have fewer than 6 colors, fill the rest with generated ones
                for(let i = extractedColors.length; i < 6; i++) {
                    html += createColorBlock(generateColor(), i);
                }
                
                paletteContainer.innerHTML = html;
                
                // Reset locks
                lockedColors.fill(false);
            }
        });

        // Initial setup
        document.addEventListener('DOMContentLoaded', function() {
            generateGradient();
            loadPaletteFromUrl();
        });
    </script>
    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "Color Palette Generator",
  "url": "https://infinitytoolspace.com/tools/palette",
  "description": "Create and copy beautiful color palettes instantly. Perfect tool for designers, developers, and artists to generate unique HEX and RGB color schemes.",
  "applicationCategory": "DesignApplication",
  "operatingSystem": "All",
  "browserRequirements": "Works on all modern browsers",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiEgbhKHmX_jdcgOIIEWTdekmXqhqSXFjeqE7VTapNaO3ieOzl0KlGe1dYPT7OEgLOjqnYIM8DrMmIUzsvoskEixvPnkC8Sj0l7d_nInuFvmonodv8E_IDHZyAGrcCNxcWiWJ0aaExcE30mfDRSODKv0fMDHuwEHOSUaMNlTqjoRSPwnfJyNtx_geDzgHY/s16000/Color%20Palette%20Generator.jpg"
}
</script>

</body>
</html>
<?php include("../footer.php")?>