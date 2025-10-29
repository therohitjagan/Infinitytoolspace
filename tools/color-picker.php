<?php
// Modern Color Picker Tool - All-in-one solution
session_start();

// Initialize saved colors array in session if it doesn't exist
if (!isset($_SESSION['saved_colors'])) {
    $_SESSION['saved_colors'] = [];
}

// Handle color saving via AJAX
if (isset($_POST['action']) && $_POST['action'] == 'save_color') {
    $color = [
        'hex' => $_POST['hex'],
        'name' => $_POST['name'],
        'timestamp' => time()
    ];
    
    // Add to saved colors (avoid duplicates)
    $exists = false;
    foreach ($_SESSION['saved_colors'] as $savedColor) {
        if ($savedColor['hex'] == $color['hex']) {
            $exists = true;
            break;
        }
    }
    
    if (!$exists) {
        $_SESSION['saved_colors'][] = $color;
        // Keep only the last 20 colors
        if (count($_SESSION['saved_colors']) > 20) {
            array_shift($_SESSION['saved_colors']);
        }
    }
    
    echo json_encode(['success' => true]);
    exit;
}

// Handle image color extraction
$extractedColors = [];
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($_FILES['image']['type'], $allowedTypes)) {
        $image = imagecreatefromstring(file_get_contents($_FILES['image']['tmp_name']));
        if ($image) {
            // Resize image for processing
            $width = imagesx($image);
            $height = imagesy($image);
            $newWidth = min($width, 300);
            $newHeight = (int)(($height / $width) * $newWidth); // Explicit int cast

            
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            
            // Sample colors from image
            $colorCounts = [];
            for ($y = 0; $y < $newHeight; $y += 3) {
                for ($x = 0; $x < $newWidth; $x += 3) {
                    $rgb = imagecolorat($resized, $x, $y);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    
                    // Group similar colors (reduce precision)
                    $r = round($r / 10) * 10;
                    $g = round($g / 10) * 10;
                    $b = round($b / 10) * 10;
                    
                    $hex = sprintf("#%02x%02x%02x", $r, $g, $b);
                    if (!isset($colorCounts[$hex])) {
                        $colorCounts[$hex] = 0;
                    }
                    $colorCounts[$hex]++;
                }
            }
            
            // Sort colors by frequency
            arsort($colorCounts);
            
            // Take top 8 colors
            $extractedColors = array_slice(array_keys($colorCounts), 0, 8);
            
            imagedestroy($image);
            imagedestroy($resized);
        }
    }
}

// Common color names data
$colorNames = [
    // Reds
    '#FF0000' => 'Red', '#CD5C5C' => 'Indian Red', '#DC143C' => 'Crimson', 
    '#B22222' => 'Firebrick', '#8B0000' => 'Dark Red', '#FF6347' => 'Tomato',
    // Pinks
    '#FFC0CB' => 'Pink', '#FF69B4' => 'Hot Pink', '#FF1493' => 'Deep Pink',
    '#C71585' => 'Medium Violet Red', '#DB7093' => 'Pale Violet Red',
    // Oranges
    '#FFA500' => 'Orange', '#FF8C00' => 'Dark Orange', '#FF7F50' => 'Coral', 
    '#FF4500' => 'Orange Red', '#FF6347' => 'Tomato',
    // Yellows
    '#FFFF00' => 'Yellow', '#FFD700' => 'Gold', '#FFFFE0' => 'Light Yellow',
    '#FFFACD' => 'Lemon Chiffon', '#BDB76B' => 'Dark Khaki',
    // Purples
    '#800080' => 'Purple', '#9370DB' => 'Medium Purple', '#8A2BE2' => 'Blue Violet', 
    '#4B0082' => 'Indigo', '#9932CC' => 'Dark Orchid', '#9400D3' => 'Dark Violet',
    // Greens
    '#008000' => 'Green', '#00FF00' => 'Lime', '#00FA9A' => 'Medium Spring Green',
    '#00FF7F' => 'Spring Green', '#90EE90' => 'Light Green', '#98FB98' => 'Pale Green',
    '#8FBC8F' => 'Dark Sea Green', '#2E8B57' => 'Sea Green', '#006400' => 'Dark Green',
    '#228B22' => 'Forest Green', '#32CD32' => 'Lime Green', '#3CB371' => 'Medium Sea Green',
    // Blues
    '#0000FF' => 'Blue', '#1E90FF' => 'Dodger Blue', '#00BFFF' => 'Deep Sky Blue',
    '#87CEEB' => 'Sky Blue', '#87CEFA' => 'Light Sky Blue', '#4682B4' => 'Steel Blue',
    '#B0C4DE' => 'Light Steel Blue', '#ADD8E6' => 'Light Blue', '#B0E0E6' => 'Powder Blue',
    '#5F9EA0' => 'Cadet Blue', '#F0F8FF' => 'Alice Blue', '#00FFFF' => 'Cyan',
    '#00CED1' => 'Dark Turquoise', '#2F4F4F' => 'Dark Slate Gray', '#000080' => 'Navy',
    '#191970' => 'Midnight Blue', '#483D8B' => 'Dark Slate Blue', '#4169E1' => 'Royal Blue',
    // Browns
    '#A52A2A' => 'Brown', '#8B4513' => 'Saddle Brown', '#D2691E' => 'Chocolate',
    '#CD853F' => 'Peru', '#DEB887' => 'Burlywood', '#F4A460' => 'Sandy Brown',
    '#DAA520' => 'Goldenrod', '#B8860B' => 'Dark Goldenrod',
    // Whites
    '#FFFFFF' => 'White', '#F5F5F5' => 'White Smoke', '#FFFAF0' => 'Floral White',
    '#F0FFF0' => 'Honeydew', '#F5FFFA' => 'Mint Cream', '#F0FFFF' => 'Azure',
    '#F0F8FF' => 'Alice Blue', '#FFF5EE' => 'Seashell', '#FAEBD7' => 'Antique White',
    '#FAF0E6' => 'Linen', '#FFF0F5' => 'Lavender Blush', '#FFE4E1' => 'Misty Rose',
    // Blacks and Grays
    '#000000' => 'Black', '#808080' => 'Gray', '#A9A9A9' => 'Dark Gray',
    '#D3D3D3' => 'Light Gray', '#778899' => 'Light Slate Gray',
    '#708090' => 'Slate Gray', '#696969' => 'Dim Gray', '#C0C0C0' => 'Silver'
];

// Helper function to find nearest color name
function findNearestColorName($hex, $colorNames) {
    // Parse the hex color
    $hex = strtoupper(ltrim($hex, '#'));
    if (strlen($hex) == 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    
    // Convert to RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    // Find closest color
    $minDistance = PHP_INT_MAX;
    $closestColor = 'Custom';
    
    foreach ($colorNames as $colorHex => $colorName) {
        $colorHex = ltrim($colorHex, '#');
        $r2 = hexdec(substr($colorHex, 0, 2));
        $g2 = hexdec(substr($colorHex, 2, 2));
        $b2 = hexdec(substr($colorHex, 4, 2));
        
        // Calculate color distance (Euclidean distance in RGB space)
        $distance = sqrt(pow($r - $r2, 2) + pow($g - $g2, 2) + pow($b - $b2, 2));
        
        if ($distance < $minDistance) {
            $minDistance = $distance;
            $closestColor = $colorName;
        }
    }
    
    // Only return a name if it's close enough
    return $minDistance < 25 ? $closestColor : 'Custom';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color Picker Tool | Create Color Palettes, Generate Gradients & More</title>
    <meta name="description" content="All-in-one color picker tool with hex, RGB, HSL, CMYK codes, eyedropper, color schemes, gradient generator, contrast checker, and more.">
    <meta name="keywords" content="color picker, html color picker, rgb color tool, hex color tool, online color picker, web design color tool, color code converter, hsl picker, ui colors">
    <link rel="canonical" href="https://infinitytoolspace.com/tools/color-picker" />

    
    <!-- Favicon -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🎨</text></svg>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.5/dist/tailwind.min.css" rel="stylesheet">
    
    <meta property="og:title" content="HTML Color Picker - Free Online Color Tool" />
<meta property="og:description" content="Select and copy color codes easily with our online color picker. Supports HEX, RGB, and HSL formats." />
<meta property="og:url" content="https://infinitytoolspace.com/tools/color-picker" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiws1jy5QkI7qqRj-nl1nNTyk-ewHy6pFTZTY5oFbqoSE_6oClp0-L2cfjnHRhzkEG0hEQiThJSe0YYXh8ERZxhz17QOYOlfsO3idPO49POhxQm_0l_cPTM8HZbr2Y_-Tf5n6B0KKH-sqpazFAYJODchDE0HnaeYiwMK3RHq-hOBtfjO_l5QkP3x9fSNmg/s16000/Online%20Color%20Picker.jpg" />
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>

    
    <!-- Custom styles -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #7209b7;
            --bg-light: #f8f9fa;
            --text-dark: #212529;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
            overflow-x: hidden;
        }
        
        .app-container {
            max-width: 1400px;
        }
        
        .color-wheel-container {
            position: relative;
            width: 240px;
            height: 240px;
            margin: 0 auto;
        }
        
        #colorWheel {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: conic-gradient(
                red, yellow, lime, cyan, blue, magenta, red
            );
            cursor: crosshair;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        #colorWheel::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20%;
            height: 20%;
            border-radius: 50%;
            background: white;
            border: 3px solid #ddd;
        }
        
        .color-selector {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
            transform: translate(-50%, -50%);
            pointer-events: none;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.3);
        }
        
        .color-preview {
            width: 100%;
            height: 120px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .color-code {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #eaeaea;
        }
        
        .color-code:hover {
            border-color: var(--primary-color);
        }
        
        .copy-btn {
            background: transparent;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 4px;
            margin-left: 8px;
            transition: color 0.2s;
        }
        
        .copy-btn:hover {
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #3048c5;
            border-color: #3048c5;
        }
        
        .slider-container {
            margin-bottom: 16px;
        }
        
        .color-slider {
            width: 100%;
            height: 12px;
            -webkit-appearance: none;
            border-radius: 6px;
            outline: none;
        }
        
        .color-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: white;
            border: 1px solid #ddd;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        
        .saved-color {
            width: 100%;
            height: 60px;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .saved-color:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .palette-color {
            height: 50px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .gradient-preview {
            height: 100px;
            border-radius: 10px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        
        .gradient-stop {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid white;
            position: absolute;
            transform: translateX(-50%);
            cursor: grab;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .gradient-track {
            height: 12px;
            background: #e9ecef;
            border-radius: 6px;
            position: relative;
            margin: 20px 12px;
        }
        
        .tab-content {
            background: white;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 20px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: #495057;
            font-weight: 500;
            padding: 12px 16px;
            border-radius: 8px 8px 0 0;
        }
        
        .nav-tabs .nav-link.active {
            background-color: white;
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }
        
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(33, 37, 41, 0.9);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            max-width: 300px;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .toast.show {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .color-wheel-container {
                width: 200px;
                height: 200px;
            }
            
            .color-preview {
                height: 80px;
            }
        }
        
        .contrast-sample {
            padding: 10px;
            margin: 5px;
            border-radius: 6px;
            text-align: center;
        }
        
        .eyedropper-preview {
            width: 100px;
            height: 100px;
            background-size: cover;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin: 0 auto;
        }
        
        .image-color {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .image-color:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="pt-3 pb-5">
    <div class="container app-container">
        <header class="text-center my-4">
            <h1 class="fw-bold text-4xl mb-2">Advanced Color Picker</h1>
            <p class="text-muted lead">All-in-one tool for designers and developers</p>
        </header>
        
        <div class="row g-4">
            <!-- Main Color Picker Column -->
            <div class="col-lg-7">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-5">
                                <div class="color-wheel-container mb-3">
                                    <div id="colorWheel"></div>
                                    <div class="color-selector" id="colorSelector"></div>
                                </div>
                                
                                <div class="slider-container">
                                    <label class="d-block mb-1">Hue</label>
                                    <input type="range" min="0" max="360" value="0" class="color-slider" id="hueSlider" style="background: linear-gradient(to right, red, yellow, lime, cyan, blue, magenta, red);">
                                </div>
                                
                                <div class="slider-container">
                                    <label class="d-block mb-1">Saturation</label>
                                    <input type="range" min="0" max="100" value="100" class="color-slider" id="saturationSlider">
                                </div>
                                
                                <div class="slider-container">
                                    <label class="d-block mb-1">Lightness</label>
                                    <input type="range" min="0" max="100" value="50" class="color-slider" id="lightnessSlider">
                                </div>
                                
                                <div class="d-flex gap-2 mt-3">
                                    <button id="eyedropperBtn" class="btn btn-sm btn-outline-primary" title="Pick color from screen">
                                        <i class="fas fa-eye-dropper me-1"></i> Eyedropper
                                    </button>
                                    <button id="saveColorBtn" class="btn btn-sm btn-primary">
                                        <i class="fas fa-save me-1"></i> Save Color
                                    </button>
                                </div>
                            </div>
                            
                            <div class="col-md-7">
                                <div class="color-preview mb-3" id="colorPreview"></div>
                                
                                <div id="colorNameDisplay" class="mb-3 fw-bold text-center fs-5">Red</div>
                                
                                <div class="color-code">
                                    <span>HEX</span>
                                    <div class="d-flex align-items-center">
                                        <input type="text" id="hexCode" class="form-control form-control-sm" value="#FF0000">
                                        <button class="copy-btn" data-clipboard-target="#hexCode">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="color-code">
                                    <span>RGB</span>
                                    <div class="d-flex align-items-center">
                                        <input type="text" id="rgbCode" class="form-control form-control-sm" value="rgb(255, 0, 0)">
                                        <button class="copy-btn" data-clipboard-target="#rgbCode">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="color-code">
                                    <span>HSL</span>
                                    <div class="d-flex align-items-center">
                                        <input type="text" id="hslCode" class="form-control form-control-sm" value="hsl(0, 100%, 50%)">
                                        <button class="copy-btn" data-clipboard-target="#hslCode">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="color-code">
                                    <span>CMYK</span>
                                    <div class="d-flex align-items-center">
                                        <input type="text" id="cmykCode" class="form-control form-control-sm" value="cmyk(0%, 100%, 100%, 0%)">
                                        <button class="copy-btn" data-clipboard-target="#cmykCode">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Color Palettes & Tools -->
                <div class="card">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <ul class="nav nav-tabs" id="colorTools" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="palette-tab" data-bs-toggle="tab" data-bs-target="#palette" type="button" role="tab" aria-controls="palette" aria-selected="true">
                                    <i class="fas fa-palette me-1"></i> Color Schemes
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="gradients-tab" data-bs-toggle="tab" data-bs-target="#gradients" type="button" role="tab" aria-controls="gradients" aria-selected="false">
                                    <i class="fas fa-brush me-1"></i> Gradients
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contrast-tab" data-bs-toggle="tab" data-bs-target="#contrast" type="button" role="tab" aria-controls="contrast" aria-selected="false">
                                    <i class="fas fa-adjust me-1"></i> Contrast
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image" type="button" role="tab" aria-controls="image" aria-selected="false">
                                    <i class="fas fa-image me-1"></i> Image Colors
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="colorToolsContent">
                        <!-- Palette Generator Tab -->
                        <div class="tab-pane fade show active" id="palette" role="tabpanel" aria-labelledby="palette-tab">
                            <div class="row mb-3 g-2">
                                <div class="col d-grid">
                                    <button class="btn btn-outline-primary btn-sm palette-btn" data-type="complementary">Complementary</button>
                                </div>
                                <div class="col d-grid">
                                    <button class="btn btn-outline-primary btn-sm palette-btn" data-type="analogous">Analogous</button>
                                </div>
                                <div class="col d-grid">
                                    <button class="btn btn-outline-primary btn-sm palette-btn" data-type="triadic">Triadic</button>
                                </div>
                                <div class="col d-grid">
                                    <button class="btn btn-outline-primary btn-sm palette-btn" data-type="tetradic">Tetradic</button>
                                </div>
                                <div class="col d-grid">
                                    <button class="btn btn-outline-primary btn-sm palette-btn" data-type="monochromatic">Monochromatic</button>
                                </div>
                            </div>
                            
                            <div id="paletteDisplay" class="row g-2 mb-3"></div>
                            
                            <div class="d-flex justify-content-between">
                                <button id="savePaletteBtn" class="btn btn-sm btn-primary">
                                    <i class="fas fa-save me-1"></i> Save Palette
                                </button>
                                <div>
                                    <button id="sharePaletteBtn" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-share-alt me-1"></i> Share
                                    </button>
                                    <button id="downloadPaletteBtn" class="btn btn-sm btn-outline-secondary ms-1">
                                        <i class="fas fa-download me-1"></i> Download
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Gradient Generator Tab -->
                        <div class="tab-pane fade" id="gradients" role="tabpanel" aria-labelledby="gradients-tab">
                            <div class="gradient-preview mb-3" id="gradientPreview"></div>
                            
                            <div class="d-flex mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gradientType" id="linearGradient" value="linear" checked>
                                    <label class="form-check-label" for="linearGradient">Linear</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gradientType" id="radialGradient" value="radial">
                                    <label class="form-check-label" for="radialGradient">Radial</label>
                                </div>
                                
                                <div class="ms-auto">
                                    <div class="input-group input-group-sm">
                                        <label class="input-group-text" for="gradientAngle">Angle</label>
                                        <input type="number" class="form-control" id="gradientAngle" value="90" min="0" max="360">
                                        <span class="input-group-text">°</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="gradient-track" id="gradientTrack">
                                <!-- Gradient stops will be added here -->
                            </div>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <button id="addGradientStopBtn" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus me-1"></i> Add Color Stop
                                </button>
                                <button id="removeGradientStopBtn" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i> Remove Last Stop
                                </button>
                            </div>
                            
                            <div class="mt-3">
                                <label class="form-label">CSS Code:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="gradientCode" readonly>
                                    <button class="btn btn-outline-secondary copy-btn" data-clipboard-target="#gradientCode">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button id="downloadGradientBtn" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-download me-1"></i> Download as Image
                                </button>
                            </div>
                        </div>
                        
                        <!-- Contrast Checker Tab -->
                        <div class="tab-pane fade" id="contrast" role="tabpanel" aria-labelledby="contrast-tab">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Text Color</label>
                                    <input type="color" class="form-control form-control-color w-100" id="textColorInput" value="#000000">
                                    <input type="text" class="form-control mt-2" id="textColorHex" value="#000000">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Background Color</label>
                                    <input type="color" class="form-control form-control-color w-100" id="bgColorInput" value="#FFFFFF">
                                    <input type="text" class="form-control mt-2" id="bgColorHex" value="#FFFFFF">
                                </div>
                            </div>
                            
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <div class="contrast-sample p-3" id="normalTextSample">
                                        Normal text (14px)
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="contrast-sample p-3" id="largeTextSample">
                                        <span style="font-size: 18px; font-weight: bold">Large text (18px bold)</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert" id="contrastResult" role="alert">
                                <p class="mb-1"><strong>Contrast Ratio: <span id="contrastRatio">21.0</span></strong></p>
                                <p class="mb-1">WCAG AA: <span id="wcagAA">Pass</span></p>
                                <p class="mb-0">WCAG AAA: <span id="wcagAAA">Pass</span></p>
                            </div>
                        </div>
                        
                        <!-- Image Color Picker Tab -->
                        <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="image-tab">
                            <form method="post" enctype="multipart/form-data" id="imageUploadForm" class="mb-3">
                                <div class="mb-3">
                                    <label for="imageFile" class="form-label">Upload an image to extract colors</label>
                                    <input class="form-control" type="file" id="imageFile" name="image" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary">Extract Colors</button>
                            </form>
                            
                            <div class="mb-3">
                                <label class="form-label">Preview</label>
                                <div id="imagePreview" class="border rounded p-2 text-center">
                                    <img id="previewImg" src="" class="img-fluid" style="max-height: 200px; display: none;">
                                    <p id="noImageText" class="text-muted m-0">No image selected</p>
                                </div>
                            </div>
                            
                            <div class="row g-2" id="extractedColors">
                                <?php if (!empty($extractedColors)): ?>
                                    <h6 class="mt-3 mb-2">Extracted Colors:</h6>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <?php foreach ($extractedColors as $color): ?>
                                            <div class="image-color" 
                                                style="background-color: <?php echo $color; ?>" 
                                                data-color="<?php echo $color; ?>" 
                                                title="<?php echo $color; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar Column -->
            <div class="col-lg-5">
                <!-- Saved & Recent Colors -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bookmark me-2"></i> Saved Colors
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="savedColorsContainer" class="row g-2">
                            <?php if (!empty($_SESSION['saved_colors'])): ?>
                                <?php foreach (array_reverse($_SESSION['saved_colors']) as $color): ?>
                                    <div class="col-3 col-md-2">
                                        <div class="saved-color mb-1" 
                                            style="background-color: <?php echo $color['hex']; ?>" 
                                            data-color="<?php echo $color['hex']; ?>"
                                            title="<?php echo $color['name']; ?>">
                                        </div>
                                        <div class="text-center small text-truncate"><?php echo $color['name']; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12 text-center text-muted py-3">
                                    No saved colors yet. Click "Save Color" to add colors here.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Share Color Panel -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-share-alt me-2"></i> Share Color
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Shareable Link</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="shareLink" readonly>
                                <button class="btn btn-outline-secondary copy-btn" data-clipboard-target="#shareLink">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button class="btn btn-sm btn-outline-primary" id="shareTwitterBtn">
                                <i class="fab fa-twitter me-1"></i> Share on Twitter
                            </button>
                            <button class="btn btn-sm btn-outline-primary" id="downloadPDFBtn">
                                <i class="fas fa-file-pdf me-1"></i> Download as PDF
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Help Panel -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-question-circle me-2"></i> Quick Help
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="helpAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#colorFormats">
                                        Color Formats Explained
                                    </button>
                                </h2>
                                <div id="colorFormats" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        <p><strong>HEX</strong>: Used in CSS, represented as #RRGGBB where RR, GG, BB are hexadecimal values.</p>
                                        <p><strong>RGB</strong>: Red, Green, Blue values from 0-255.</p>
                                        <p><strong>HSL</strong>: Hue (0-360°), Saturation (0-100%), Lightness (0-100%).</p>
                                        <p><strong>CMYK</strong>: Cyan, Magenta, Yellow, Key (Black) percentages used in printing.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#colorSchemes">
                                        Color Schemes Guide
                                    </button>
                                </h2>
                                <div id="colorSchemes" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        <p><strong>Complementary</strong>: Colors opposite each other on the color wheel.</p>
                                        <p><strong>Analogous</strong>: Colors adjacent to each other on the color wheel.</p>
                                        <p><strong>Triadic</strong>: Three colors evenly spaced around the color wheel.</p>
                                        <p><strong>Tetradic</strong>: Four colors arranged in two complementary pairs.</p>
                                        <p><strong>Monochromatic</strong>: Different shades, tints, and tones of a single color.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accessibilityHelp">
                                        Accessibility Tips
                                    </button>
                                </h2>
                                <div id="accessibilityHelp" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        <p><strong>WCAG AA</strong> requires a contrast ratio of at least:</p>
                                        <ul>
                                            <li>4.5:1 for normal text</li>
                                            <li>3:1 for large text (18pt or 14pt bold)</li>
                                        </ul>
                                        <p><strong>WCAG AAA</strong> requires a contrast ratio of at least:</p>
                                        <ul>
                                            <li>7:1 for normal text</li>
                                            <li>4.5:1 for large text</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Toast Notification -->
    <div class="toast" id="notificationToast">
        <div class="toast-body"></div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Clipboard.js -->
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
    
    <!-- html2canvas and jsPDF for exports -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
    
    <script>
        // Initialize variables
        let currentColor = {
            hex: '#FF0000',
            hsl: { h: 0, s: 100, l: 50 },
            rgb: { r: 255, g: 0, b: 0 },
            cmyk: { c: 0, m: 100, y: 100, k: 0 },
            name: 'Red'
        };
        
        let currentPalette = [];
        let gradientStops = [
            { color: '#FF0000', position: 0 },
            { color: '#0000FF', position: 100 }
        ];
        
        // DOM Elements
        const colorPreview = document.getElementById('colorPreview');
        const colorSelector = document.getElementById('colorSelector');
        const colorWheel = document.getElementById('colorWheel');
        const hueSlider = document.getElementById('hueSlider');
        const saturationSlider = document.getElementById('saturationSlider');
        const lightnessSlider = document.getElementById('lightnessSlider');
        const hexCode = document.getElementById('hexCode');
        const rgbCode = document.getElementById('rgbCode');
        const hslCode = document.getElementById('hslCode');
        const cmykCode = document.getElementById('cmykCode');
        const colorNameDisplay = document.getElementById('colorNameDisplay');
        const eyedropperBtn = document.getElementById('eyedropperBtn');
        const saveColorBtn = document.getElementById('saveColorBtn');
        const notificationToast = document.getElementById('notificationToast');
        const savedColorsContainer = document.getElementById('savedColorsContainer');
        
        // Initialize clipboard.js
        new ClipboardJS('.copy-btn');
        
        // Helper functions
        function hexToRgb(hex) {
            hex = hex.replace(/^#/, '');
            if(hex.length === 3) {
                hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
            }
            const r = parseInt(hex.substring(0, 2), 16);
            const g = parseInt(hex.substring(2, 4), 16);
            const b = parseInt(hex.substring(4, 6), 16);
            return { r, g, b };
        }
        
        function rgbToHex(r, g, b) {
            return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase();
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
        
        function rgbToCmyk(r, g, b) {
            r = r / 255;
            g = g / 255;
            b = b / 255;
            
            const k = 1 - Math.max(r, g, b);
            const c = k === 1 ? 0 : (1 - r - k) / (1 - k);
            const m = k === 1 ? 0 : (1 - g - k) / (1 - k);
            const y = k === 1 ? 0 : (1 - b - k) / (1 - k);
            
            return {
                c: Math.round(c * 100),
                m: Math.round(m * 100),
                y: Math.round(y * 100),
                k: Math.round(k * 100)
            };
        }
        
        function getColorName(hex) {
            fetch('color-names.php?hex=' + encodeURIComponent(hex))
                .then(response => response.json())
                .then(data => {
                    currentColor.name = data.name;
                    colorNameDisplay.textContent = data.name;
                });
        }
        
        function updateColorFromHsl(h, s, l) {
            currentColor.hsl = { h, s, l };
            const rgb = hslToRgb(h, s, l);
            currentColor.rgb = rgb;
            const hex = rgbToHex(rgb.r, rgb.g, rgb.b);
            currentColor.hex = hex;
            currentColor.cmyk = rgbToCmyk(rgb.r, rgb.g, rgb.b);
            
            // Update UI
            colorPreview.style.backgroundColor = hex;
            hexCode.value = hex;
            rgbCode.value = `rgb(${rgb.r}, ${rgb.g}, ${rgb.b})`;
            hslCode.value = `hsl(${h}, ${s}%, ${l}%)`;
            cmykCode.value = `cmyk(${currentColor.cmyk.c}%, ${currentColor.cmyk.m}%, ${currentColor.cmyk.y}%, ${currentColor.cmyk.k}%)`;
            
            // Update color wheel position
            const angle = (h * Math.PI) / 180;
            const radius = (s / 100) * (colorWheel.offsetWidth / 2);
            const x = Math.cos(angle) * radius + colorWheel.offsetWidth / 2;
            const y = Math.sin(angle) * radius + colorWheel.offsetHeight / 2;
            colorSelector.style.left = `${x}px`;
            colorSelector.style.top = `${y}px`;
            
            // Update sliders
            hueSlider.value = h;
            saturationSlider.value = s;
            lightnessSlider.value = l;
            
            // Update saturation slider background
            saturationSlider.style.background = `linear-gradient(to right, hsl(${h}, 0%, ${l}%), hsl(${h}, 100%, ${l}%))`;
            
            // Update lightness slider background
            lightnessSlider.style.background = `linear-gradient(to right, hsl(${h}, ${s}%, 0%), hsl(${h}, ${s}%, 50%), hsl(${h}, ${s}%, 100%))`;
            
            // Get color name
            const colorNamesArray = <?php echo json_encode($colorNames); ?>;
            let closestDistance = Number.MAX_VALUE;
            let closestName = 'Custom';
            
            for (const [colorHex, name] of Object.entries(colorNamesArray)) {
                const colorRgb = hexToRgb(colorHex);
                const distance = Math.sqrt(
                    Math.pow(rgb.r - colorRgb.r, 2) +
                    Math.pow(rgb.g - colorRgb.g, 2) +
                    Math.pow(rgb.b - colorRgb.b, 2)
                );
                
                if (distance < closestDistance) {
                    closestDistance = distance;
                    closestName = name;
                }
            }
            
            currentColor.name = closestDistance < 25 ? closestName : 'Custom';
            colorNameDisplay.textContent = currentColor.name;
            
            // Update share link
            document.getElementById('shareLink').value = window.location.origin + window.location.pathname + '?color=' + hex.substring(1);
            
            // Update contrast checker if active
            if (document.getElementById('contrast-tab').getAttribute('aria-selected') === 'true') {
                updateContrast();
            }
        }
        
        // Set initial color
        updateColorFromHsl(0, 100, 50);
        
        // Color wheel events
        colorWheel.addEventListener('mousedown', startColorSelection);
        colorWheel.addEventListener('touchstart', startColorSelection, { passive: false });
        
        function startColorSelection(e) {
            e.preventDefault();
            
            document.addEventListener('mousemove', moveColorSelection);
            document.addEventListener('touchmove', moveColorSelection, { passive: false });
            document.addEventListener('mouseup', stopColorSelection);
            document.addEventListener('touchend', stopColorSelection);
            
            moveColorSelection(e);
        }
        
        function moveColorSelection(e) {
            e.preventDefault();
            
            let clientX, clientY;
            
            if (e.type === 'touchmove' || e.type === 'touchstart') {
                clientX = e.touches[0].clientX;
                clientY = e.touches[0].clientY;
            } else {
                clientX = e.clientX;
                clientY = e.clientY;
            }
            
            const rect = colorWheel.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            let x = clientX - centerX;
            let y = clientY - centerY;
            
            // Calculate angle and distance from center
            const angle = Math.atan2(y, x);
            let hue = Math.round(((angle * 180) / Math.PI + 360) % 360);
            
            const distance = Math.sqrt(x * x + y * y);
            const maxDistance = rect.width / 2;
            let saturation = Math.min(100, Math.round((distance / maxDistance) * 100));
            
            // Keep the selector within the wheel
            if (distance > maxDistance) {
                x = (x / distance) * maxDistance;
                y = (y / distance) * maxDistance;
                saturation = 100;
            }
            
            // Position the selector
            colorSelector.style.left = x + rect.width / 2 + 'px';
            colorSelector.style.top = y + rect.height / 2 + 'px';
            
            updateColorFromHsl(hue, saturation, currentColor.hsl.l);
        }
        
        function stopColorSelection() {
            document.removeEventListener('mousemove', moveColorSelection);
            document.removeEventListener('touchmove', moveColorSelection);
            document.removeEventListener('mouseup', stopColorSelection);
            document.removeEventListener('touchend', stopColorSelection);
        }
        
        // Slider events
        hueSlider.addEventListener('input', () => {
            updateColorFromHsl(
                parseInt(hueSlider.value),
                currentColor.hsl.s,
                currentColor.hsl.l
            );
        });
        
        saturationSlider.addEventListener('input', () => {
            updateColorFromHsl(
                currentColor.hsl.h,
                parseInt(saturationSlider.value),
                currentColor.hsl.l
            );
        });
        
        lightnessSlider.addEventListener('input', () => {
            updateColorFromHsl(
                currentColor.hsl.h,
                currentColor.hsl.s,
                parseInt(lightnessSlider.value)
            );
        });
        
        // Input fields events
        hexCode.addEventListener('input', () => {
            const hex = hexCode.value;
            if (/^#[0-9A-Fa-f]{6}$/.test(hex)) {
                const rgb = hexToRgb(hex);
                const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
                updateColorFromHsl(hsl.h, hsl.s, hsl.l);
            }
        });
        
        // Save color button
        saveColorBtn.addEventListener('click', () => {
            // Save color via AJAX
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=save_color&hex=${encodeURIComponent(currentColor.hex)}&name=${encodeURIComponent(currentColor.name)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add to saved colors UI
                    const colorDiv = document.createElement('div');
                    colorDiv.className = 'col-3 col-md-2';
                    colorDiv.innerHTML = `
                        <div class="saved-color mb-1" 
                            style="background-color: ${currentColor.hex}" 
                            data-color="${currentColor.hex}"
                            title="${currentColor.name}">
                        </div>
                        <div class="text-center small text-truncate">${currentColor.name}</div>
                    `;
                    
                    // Remove "no saved colors" message if it exists
                    const noSavedMsg = savedColorsContainer.querySelector('.text-muted');
                    if (noSavedMsg) {
                        noSavedMsg.remove();
                    }
                    
                    // Insert at the beginning
                    savedColorsContainer.insertBefore(colorDiv, savedColorsContainer.firstChild);
                    
                    // Show toast notification
                    showNotification(`Color ${currentColor.name} saved!`);
                }
            });
        });
        
        // Click on saved color
        savedColorsContainer.addEventListener('click', (e) => {
            const colorElement = e.target.closest('.saved-color');
            if (colorElement) {
                const hex = colorElement.dataset.color;
                const rgb = hexToRgb(hex);
                const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
                updateColorFromHsl(hsl.h, hsl.s, hsl.l);
            }
        });
        
        // Eyedropper tool
        eyedropperBtn.addEventListener('click', () => {
            if (!window.EyeDropper) {
                showNotification('Eyedropper API is not supported in your browser', 'warning');
                return;
            }
            
            const eyeDropper = new EyeDropper();
            eyeDropper.open()
                .then(result => {
                    const hex = result.sRGBHex;
                    const rgb = hexToRgb(hex);
                    const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
                    updateColorFromHsl(hsl.h, hsl.s, hsl.l);
                })
                .catch(error => {
                    console.log('EyeDropper error:', error);
                });
        });
        
        // Show notification
        function showNotification(message, type = 'success') {
            const toast = document.getElementById('notificationToast');
            toast.querySelector('.toast-body').textContent = message;
            
            // Set color based on type
            if (type === 'success') {
                toast.style.backgroundColor = 'rgba(25, 135, 84, 0.9)';
            } else if (type === 'warning') {
                toast.style.backgroundColor = 'rgba(255, 193, 7, 0.9)';
                toast.style.color = '#000';
            } else if (type === 'error') {
                toast.style.backgroundColor = 'rgba(220, 53, 69, 0.9)';
            }
            
            toast.classList.add('show');
            
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
        
        // Show success notification after copy
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-clipboard-target');
                const text = document.querySelector(targetId).value;
                showNotification(`Copied: ${text}`);
            });
        });
        
        // Color Palette Generator
        document.querySelectorAll('.palette-btn').forEach(button => {
            button.addEventListener('click', () => {
                const type = button.getAttribute('data-type');
                generatePalette(type);
            });
        });
        
        function generatePalette(type) {
            const h = currentColor.hsl.h;
            const s = currentColor.hsl.s;
            const l = currentColor.hsl.l;
            
            let colors = [];
            
            switch (type) {
                case 'complementary':
                    colors = [
                        { h, s, l },
                        { h: (h + 180) % 360, s, l }
                    ];
                    break;
                
                case 'analogous':
                    colors = [
                        { h: (h - 30 + 360) % 360, s, l },
                        { h, s, l },
                        { h: (h + 30) % 360, s, l }
                    ];
                    break;
                
                case 'triadic':
                    colors = [
                        { h, s, l },
                        { h: (h + 120) % 360, s, l },
                        { h: (h + 240) % 360, s, l }
                    ];
                    break;
                
                case 'tetradic':
                    colors = [
                        { h, s, l },
                        { h: (h + 90) % 360, s, l },
                        { h: (h + 180) % 360, s, l },
                        { h: (h + 270) % 360, s, l }
                    ];
                    break;
                
                case 'monochromatic':
                    colors = [
                        { h, s, l: Math.max(0, l - 30) },
                        { h, s: Math.max(0, s - 15), l: Math.max(0, l - 15) },
                        { h, s, l },
                        { h, s: Math.min(100, s + 15), l: Math.min(100, l + 15) },
                        { h, s, l: Math.min(100, l + 30) }
                    ];
                    break;
            }
            
            // Convert HSL colors to HEX
            currentPalette = colors.map(hslColor => {
                const rgb = hslToRgb(hslColor.h, hslColor.s, hslColor.l);
                const hex = rgbToHex(rgb.r, rgb.g, rgb.b);
                return hex;
            });
            
            // Display the palette
            displayPalette();
        }
        
        function displayPalette() {
            const paletteDisplay = document.getElementById('paletteDisplay');
            paletteDisplay.innerHTML = '';
            
            currentPalette.forEach(color => {
                const colorDiv = document.createElement('div');
                colorDiv.className = 'col';
                colorDiv.innerHTML = `
                    <div class="palette-color" style="background-color: ${color}"></div>
                    <div class="small text-center mt-1">${color}</div>
                `;
                colorDiv.querySelector('.palette-color').addEventListener('click', () => {
                    const rgb = hexToRgb(color);
                    const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
                    updateColorFromHsl(hsl.h, hsl.s, hsl.l);
                });
                paletteDisplay.appendChild(colorDiv);
            });
        }
        
        // Download palette as image
        document.getElementById('downloadPaletteBtn').addEventListener('click', () => {
            if (currentPalette.length === 0) {
                showNotification('Generate a palette first', 'warning');
                return;
            }
            
            html2canvas(document.getElementById('paletteDisplay')).then(canvas => {
                const link = document.createElement('a');
                link.download = 'color-palette.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        });
        
        // Share palette
        document.getElementById('sharePaletteBtn').addEventListener('click', () => {
            if (currentPalette.length === 0) {
                showNotification('Generate a palette first', 'warning');
                return;
            }
            
            const paletteString = currentPalette.join(',');
            const shareUrl = `${window.location.origin}${window.location.pathname}?palette=${encodeURIComponent(paletteString)}`;
            
            navigator.clipboard.writeText(shareUrl).then(() => {
                showNotification('Palette URL copied to clipboard!');
            });
        });
        
        // Contrast Checker
        const textColorInput = document.getElementById('textColorInput');
        const bgColorInput = document.getElementById('bgColorInput');
        const textColorHex = document.getElementById('textColorHex');
        const bgColorHex = document.getElementById('bgColorHex');
        const normalTextSample = document.getElementById('normalTextSample');
        const largeTextSample = document.getElementById('largeTextSample');
        const contrastRatio = document.getElementById('contrastRatio');
        const wcagAA = document.getElementById('wcagAA');
        const wcagAAA = document.getElementById('wcagAAA');
        const contrastResult = document.getElementById('contrastResult');
        
        function updateContrast() {
            const textColor = textColorHex.value;
            const bgColor = bgColorHex.value;
            
            // Update samples
            normalTextSample.style.color = textColor;
            normalTextSample.style.backgroundColor = bgColor;
            largeTextSample.style.color = textColor;
            largeTextSample.style.backgroundColor = bgColor;
            
            // Calculate contrast ratio
            const textRgb = hexToRgb(textColor);
            const bgRgb = hexToRgb(bgColor);
            
            const textLuminance = calculateLuminance(textRgb.r, textRgb.g, textRgb.b);
            const bgLuminance = calculateLuminance(bgRgb.r, bgRgb.g, bgRgb.b);
            
            const ratio = textLuminance > bgLuminance 
                ? (textLuminance + 0.05) / (bgLuminance + 0.05)
                : (bgLuminance + 0.05) / (textLuminance + 0.05);
            
            contrastRatio.textContent = ratio.toFixed(2);
            
            // WCAG compliance
            const aaSmallText = ratio >= 4.5;
            const aaLargeText = ratio >= 3;
            const aaaSmallText = ratio >= 7;
            const aaaLargeText = ratio >= 4.5;
            
            wcagAA.textContent = aaSmallText ? 'Pass' : 'Fail (normal text) ' + (aaLargeText ? 'Pass' : 'Fail') + ' (large text)';
            wcagAAA.textContent = aaaSmallText ? 'Pass' : 'Fail (normal text) ' + (aaaLargeText ? 'Pass' : 'Fail') + ' (large text)';
            
            wcagAA.className = aaSmallText && aaLargeText ? 'text-success' : 'text-danger';
            wcagAAA.className = aaaSmallText && aaaLargeText ? 'text-success' : 'text-danger';
            
            // Set alert color
            if (aaaSmallText) {
                contrastResult.className = 'alert alert-success';
            } else if (aaSmallText) {
                contrastResult.className = 'alert alert-warning';
            } else {
                contrastResult.className = 'alert alert-danger';
            }
        }
        
        function calculateLuminance(r, g, b) {
            const a = [r, g, b].map(v => {
                v /= 255;
                return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
            });
            return a[0] * 0.2126 + a[1] * 0.7152 + a[2] * 0.0722;
        }
        
        textColorInput.addEventListener('input', () => {
            textColorHex.value = textColorInput.value;
            updateContrast();
        });
        
        bgColorInput.addEventListener('input', () => {
            bgColorHex.value = bgColorInput.value;
            updateContrast();
        });
        
        textColorHex.addEventListener('input', () => {
            if (/^#[0-9A-Fa-f]{6}$/.test(textColorHex.value)) {
                textColorInput.value = textColorHex.value;
                updateContrast();
            }
        });
        
        bgColorHex.addEventListener('input', () => {
            if (/^#[0-9A-Fa-f]{6}$/.test(bgColorHex.value)) {
                bgColorInput.value = bgColorHex.value;
                updateContrast();
            }
        });
        
        // Gradient Generator
        const gradientPreview = document.getElementById('gradientPreview');
        const gradientTrack = document.getElementById('gradientTrack');
        const gradientAngle = document.getElementById('gradientAngle');
        const gradientCode = document.getElementById('gradientCode');
        const linearGradient = document.getElementById('linearGradient');
        const radialGradient = document.getElementById('radialGradient');
        
        function updateGradient() {
            // Clear existing stops
            gradientTrack.innerHTML = '';
            
            // Create gradient CSS
            let gradientCSS = '';
            
            if (linearGradient.checked) {
                gradientCSS = `linear-gradient(${gradientAngle.value}deg, `;
            } else {
                gradientCSS = 'radial-gradient(circle, ';
            }
            
            // Add color stops
            const stops = gradientStops.map(stop => `${stop.color} ${stop.position}%`).join(', ');
            gradientCSS += stops + ')';
            
            // Update preview
            gradientPreview.style.background = gradientCSS;
            
            // Update code
            gradientCode.value = `background: ${gradientCSS};`;
            
            // Add stops to track
            gradientStops.forEach(stop => {
                const stopElement = document.createElement('div');
                stopElement.className = 'gradient-stop';
                stopElement.style.backgroundColor = stop.color;
                stopElement.style.left = `${stop.position}%`;
                stopElement.setAttribute('data-position', stop.position);
                
                // Make stop draggable
                stopElement.addEventListener('mousedown', startDragStop);
                stopElement.addEventListener('touchstart', startDragStop, { passive: false });
                
                // Click to select color
                stopElement.addEventListener('click', () => {
                    const colorPicker = document.createElement('input');
                    colorPicker.type = 'color';
                    colorPicker.value = stop.color;
                    colorPicker.style.opacity = '0';
                    colorPicker.style.position = 'absolute';
                    colorPicker.style.pointerEvents = 'none';
                    document.body.appendChild(colorPicker);
                    
                    colorPicker.addEventListener('input', () => {
                        stop.color = colorPicker.value;
                        stopElement.style.backgroundColor = colorPicker.value;
                        updateGradient();
                    });
                    
                    colorPicker.addEventListener('change', () => {
                        document.body.removeChild(colorPicker);
                    });
                    
                    colorPicker.click();
                });
                
                gradientTrack.appendChild(stopElement);
            });
        }
        
        function startDragStop(e) {
            e.preventDefault();
            
            const stopElement = e.target;
            const trackRect = gradientTrack.getBoundingClientRect();
            const trackWidth = trackRect.width;
            
            document.addEventListener('mousemove', moveStop);
            document.addEventListener('touchmove', moveStop, { passive: false });
            document.addEventListener('mouseup', stopDragStop);
            document.addEventListener('touchend', stopDragStop);
            
            function moveStop(e) {
                e.preventDefault();
                
                let clientX;
                
                if (e.type === 'touchmove') {
                    clientX = e.touches[0].clientX;
                } else {
                    clientX = e.clientX;
                }
                
                let position = ((clientX - trackRect.left) / trackWidth) * 100;
                position = Math.max(0, Math.min(100, position));
                
                stopElement.style.left = `${position}%`;
                
                // Update the gradient stop position
                const index = gradientStops.findIndex(stop => 
                    stop.position === parseFloat(stopElement.getAttribute('data-position'))
                );
                
                if (index !== -1) {
                    gradientStops[index].position = position;
                    stopElement.setAttribute('data-position', position);
                    updateGradient();
                }
            }
            
            function stopDragStop() {
                document.removeEventListener('mousemove', moveStop);
                document.removeEventListener('touchmove', moveStop);
                document.removeEventListener('mouseup', stopDragStop);
                document.removeEventListener('touchend', stopDragStop);
            }
        }
        
        // Initialize gradient
        updateGradient();
        
        // Gradient controls
        linearGradient.addEventListener('change', updateGradient);
        radialGradient.addEventListener('change', updateGradient);
        gradientAngle.addEventListener('input', updateGradient);
        
        // Add gradient stop
        document.getElementById('addGradientStopBtn').addEventListener('click', () => {
            if (gradientStops.length >= 10) {
                showNotification('Maximum 10 stops allowed', 'warning');
                return;
            }
            
            gradientStops.push({
                color: currentColor.hex,
                position: 50
            });
            
            updateGradient();
        });
        
        // Remove gradient stop
        document.getElementById('removeGradientStopBtn').addEventListener('click', () => {
            if (gradientStops.length <= 2) {
                showNotification('Minimum 2 stops required', 'warning');
                return;
            }
            
            gradientStops.pop();
            updateGradient();
        });
        
        // Download gradient
        document.getElementById('downloadGradientBtn').addEventListener('click', () => {
            html2canvas(gradientPreview).then(canvas => {
                const link = document.createElement('a');
                link.download = 'gradient.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        });
        
        // Image color extractor
        const imageFile = document.getElementById('imageFile');
        const previewImg = document.getElementById('previewImg');
        const noImageText = document.getElementById('noImageText');
        
        imageFile.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                    noImageText.style.display = 'none';
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Click on extracted color
        document.getElementById('extractedColors').addEventListener('click', (e) => {
            const colorElement = e.target.closest('.image-color');
            if (colorElement) {
                const hex = colorElement.dataset.color;
                const rgb = hexToRgb(hex);
                const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
                updateColorFromHsl(hsl.h, hsl.s, hsl.l);
            }
        });
        
        // Share on Twitter
        document.getElementById('shareTwitterBtn').addEventListener('click', () => {
            const text = `Check out this color: ${currentColor.hex} (${currentColor.name})`;
            const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(window.location.href)}`;
            window.open(url, '_blank');
        });
        
        // Download as PDF
        document.getElementById('downloadPDFBtn').addEventListener('click', () => {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            doc.setFillColor(hexToRgb(currentColor.hex).r, hexToRgb(currentColor.hex).g, hexToRgb(currentColor.hex).b);
            doc.rect(20, 20, 170, 100, 'F');
            
            doc.setTextColor(0, 0, 0);
            doc.setFont("helvetica", "bold");
            doc.setFontSize(24);
            doc.text(currentColor.name, 20, 140);
            
            doc.setFontSize(14);
            doc.text(`HEX: ${currentColor.hex}`, 20, 160);
            doc.text(`RGB: rgb(${currentColor.rgb.r}, ${currentColor.rgb.g}, ${currentColor.rgb.b})`, 20, 170);
            doc.text(`HSL: hsl(${currentColor.hsl.h}, ${currentColor.hsl.s}%, ${currentColor.hsl.l}%)`, 20, 180);
            doc.text(`CMYK: cmyk(${currentColor.cmyk.c}%, ${currentColor.cmyk.m}%, ${currentColor.cmyk.y}%, ${currentColor.cmyk.k}%)`, 20, 190);
            
            doc.setFontSize(10);
            doc.setTextColor(100, 100, 100);
            doc.text("Created with Color Picker Tool", 20, 210);
            
            doc.save(`${currentColor.name.replace(/\s+/g, '-').toLowerCase()}-color.pdf`);
        });
        
        // Check for URL parameters on load
        window.addEventListener('load', () => {
            const params = new URLSearchParams(window.location.search);
            
            // Load color from URL
            if (params.has('color')) {
                const hex = '#' + params.get('color');
                if (/^#[0-9A-Fa-f]{6}$/.test(hex)) {
                    const rgb = hexToRgb(hex);
                    const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
                    updateColorFromHsl(hsl.h, hsl.s, hsl.l);
                }
            }
            
            // Load palette from URL
            if (params.has('palette')) {
                const paletteString = params.get('palette');
                const colors = paletteString.split(',');
                if (colors.length > 0 && colors.every(color => /^#[0-9A-Fa-f]{6}$/.test(color))) {
                    currentPalette = colors;
                    displayPalette();
                    
                    // Select the palette tab
                    const paletteTab = document.getElementById('palette-tab');
                    const tabInstance = new bootstrap.Tab(paletteTab);
                    tabInstance.show();
                }
            }
        });
    </script>

    <!-- SEO Optimizations -->
    <footer class="mt-5 p-4 bg-white rounded shadow-sm">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <h3>Advanced Color Picker Tool</h3>
                    <p>Our all-in-one color picker tool helps designers and developers select perfect colors for their projects. Features include color format conversion, palette generation, gradient creation, and accessibility checking.</p>
                </div>
                <div class="col-md-6">
                    <h4>Features</h4>
                    <ul class="list-unstyled">
                        <li>✓ Intuitive color wheel selection</li>
                        <li>✓ HEX, RGB, HSL, CMYK formats</li>
                        <li>✓ Color scheme generator</li>
                        <li>✓ Gradient creator</li>
                        <li>✓ WCAG contrast checker</li>
                        <li>✓ Image color extraction</li>
                        <li>✓ Eyedropper tool</li>
                        <li>✓ Responsive design</li>
                    </ul>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <h4>Popular Color Searches</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="?color=FF0000" class="text-decoration-none">
                            <span class="badge bg-danger p-2">Red Colors</span>
                        </a>
                        <a href="?color=0000FF" class="text-decoration-none">
                            <span class="badge bg-primary p-2">Blue Colors</span>
                        </a>
                        <a href="?color=00FF00" class="text-decoration-none">
                            <span class="badge bg-success p-2">Green Colors</span>
                        </a>
                        <a href="?color=FFFF00" class="text-decoration-none">
                            <span class="badge bg-warning text-dark p-2">Yellow Colors</span>
                        </a>
                        <a href="?color=800080" class="text-decoration-none">
                            <span class="badge p-2" style="background-color: #800080">Purple Colors</span>
                        </a>
                        <a href="?color=FFA500" class="text-decoration-none">
                            <span class="badge p-2" style="background-color: #FFA500">Orange Colors</span>
                        </a>
                        <a href="?color=FFC0CB" class="text-decoration-none">
                            <span class="badge p-2" style="background-color: #FFC0CB; color: #000">Pink Colors</span>
                        </a>
                        <a href="?color=A52A2A" class="text-decoration-none">
                            <span class="badge p-2" style="background-color: #A52A2A">Brown Colors</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-muted">© <?php echo date('Y'); ?> Color Picker Tool | Infinitytoolspace. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "HTML Color Picker",
  "url": "https://infinitytoolspace.com/tools/color-picker",
  "description": "Free online color picker tool to select and convert colors in HEX, RGB, and HSL formats for design and development use.",
  "applicationCategory": "DesignApplication",
  "operatingSystem": "All",
  "browserRequirements": "Modern browser required",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiws1jy5QkI7qqRj-nl1nNTyk-ewHy6pFTZTY5oFbqoSE_6oClp0-L2cfjnHRhzkEG0hEQiThJSe0YYXh8ERZxhz17QOYOlfsO3idPO49POhxQm_0l_cPTM8HZbr2Y_-Tf5n6B0KKH-sqpazFAYJODchDE0HnaeYiwMK3RHq-hOBtfjO_l5QkP3x9fSNmg/s16000/Online%20Color%20Picker.jpg"
}
</script>
</body>


</html>