<?php
/**
 * Image to Color Tool
 * 
 * A tool to extract colors from uploaded images, with features including:
 * - Image upload (JPG, PNG, WebP, etc.)
 * - Dominant color extraction
 * - Color palette generation
 * - HEX, RGB, and HSL values
 * - Copy to clipboard functionality
 * - Color picker from image
 * - Similar color suggestions
 * - Realtime extraction
 */

// Process form submission for image upload

/**
 * Add this at the beginning of your main PHP script
 * This will clean up old files each time someone uses your image tool
 */

function cleanupOldUploads() {
    $uploadsDir = "uploads/";
    $maxFileAge = 3600; // 1 hour in seconds
    
    // Check if directory exists
    if (!file_exists($uploadsDir)) {
        return;
    }
    
    $now = time();
    
    // Scan directory for files
    $files = scandir($uploadsDir);
    foreach ($files as $file) {
        // Skip directory entries and hidden files
        if ($file === '.' || $file === '..' || substr($file, 0, 1) === '.') {
            continue;
        }
        
        $filePath = $uploadsDir . $file;
        
        // Check if it's a file and older than the max age
        if (is_file($filePath) && ($now - filemtime($filePath) > $maxFileAge)) {
            unlink($filePath);
        }
    }
}

// Call the cleanup function
cleanupOldUploads();

// The rest of your existing code...

$errorMsg = "";
$uploadedImage = "";
$dominantColors = [];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imageUpload"]) && $_FILES["imageUpload"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $uploadFile = $_FILES["imageUpload"];
    
    if ($uploadFile["error"] !== UPLOAD_ERR_OK) {
        $errorMsg = "Upload failed with error code: " . $uploadFile["error"];
    } elseif (!in_array($uploadFile["type"], $allowedTypes)) {
        $errorMsg = "Only JPG, PNG, WebP, and GIF files are allowed.";
    } elseif ($uploadFile["size"] > 5000000) { // 5MB max
        $errorMsg = "File size too large. Maximum 5MB allowed.";
    } else {
        $tempDir = "uploads/";
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        
        $tempFile = $tempDir . uniqid() . "_" . basename($uploadFile["name"]);
        if (move_uploaded_file($uploadFile["tmp_name"], $tempFile)) {
            $uploadedImage = $tempFile;
            
            // Extract dominant colors (simplified method - for production, use a library like ColorThief)
            try {
                $image = imagecreatefromstring(file_get_contents($uploadedImage));
                if ($image) {
                    $width = imagesx($image);
                    $height = imagesy($image);
                    $sampleSize = min($width, $height) / 10;
                    
                    $colorCounts = [];
                    for ($x = 0; $x < $width; $x += $sampleSize) {
                        for ($y = 0; $y < $height; $y += $sampleSize) {
                            $rgb = imagecolorat($image, (int)$x, (int)$y);
                            $r = ($rgb >> 16) & 0xFF;
                            $g = ($rgb >> 8) & 0xFF;
                            $b = $rgb & 0xFF;
                            
                            // Simplify colors to reduce count (group similar colors)
                            $r = round($r/10) * 10;
                            $g = round($g/10) * 10;
                            $b = round($b/10) * 10;
                            
                            $hexColor = sprintf("#%02x%02x%02x", $r, $g, $b);
                            
                            if (!isset($colorCounts[$hexColor])) {
                                $colorCounts[$hexColor] = 0;
                            }
                            $colorCounts[$hexColor]++;
                        }
                    }
                    
                    // Sort and get top colors
                    arsort($colorCounts);
                    $dominantColors = array_slice(array_keys($colorCounts), 0, 6);
                    
                    imagedestroy($image);
                }
            } catch (Exception $e) {
                $errorMsg = "Error processing image: " . $e->getMessage();
            }
        } else {
            $errorMsg = "Error saving uploaded file.";
        }
    }
}

// Function to convert HEX to RGB
function hexToRgb($hex) {
    list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
    return ["r" => $r, "g" => $g, "b" => $b];
}

// Function to convert RGB to HSL
function rgbToHsl($r, $g, $b) {
    $r /= 255;
    $g /= 255;
    $b /= 255;
    
    $max = max($r, $g, $b);
    $min = min($r, $g, $b);
    $l = ($max + $min) / 2;
    
    if ($max == $min) {
        $h = $s = 0; // achromatic
    } else {
        $d = $max - $min;
        $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
        
        switch ($max) {
            case $r:
                $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
                break;
            case $g:
                $h = ($b - $r) / $d + 2;
                break;
            case $b:
                $h = ($r - $g) / $d + 4;
                break;
        }
        
        $h /= 6;
    }
    
    return [
        "h" => round($h * 360),
        "s" => round($s * 100),
        "l" => round($l * 100)
    ];
}


// Process URL image submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["imageUrl"]) && !empty($_POST["imageUrl"])) {
    $imageUrl = trim($_POST["imageUrl"]);
    
    // Validate URL
    if (filter_var($imageUrl, FILTER_VALIDATE_URL) === FALSE) {
        $errorMsg = "Invalid URL format.";
    } else {
        try {
            // Get image content
            $imageContent = @file_get_contents($imageUrl);
            
            if ($imageContent === FALSE) {
                $errorMsg = "Unable to fetch image from the provided URL.";
            } else {
                $tempDir = "uploads/";
                if (!file_exists($tempDir)) {
                    mkdir($tempDir, 0777, true);
                }
                
                // Create a unique filename
                $tempFile = $tempDir . uniqid() . '.jpg';
                file_put_contents($tempFile, $imageContent);
                
                $uploadedImage = $tempFile;
                
                // Extract dominant colors (same as before)
                try {
                    $image = imagecreatefromstring($imageContent);
                    if ($image) {
                        $width = imagesx($image);
                        $height = imagesy($image);
                        $sampleSize = min($width, $height) / 10;
                        
                        $colorCounts = [];
                        for ($x = 0; $x < $width; $x += $sampleSize) {
                            for ($y = 0; $y < $height; $y += $sampleSize) {
                                $rgb = imagecolorat($image, (int)$x, (int)$y);
                                $r = ($rgb >> 16) & 0xFF;
                                $g = ($rgb >> 8) & 0xFF;
                                $b = $rgb & 0xFF;
                                
                                // Simplify colors
                                $r = round($r/10) * 10;
                                $g = round($g/10) * 10;
                                $b = round($b/10) * 10;
                                
                                $hexColor = sprintf("#%02x%02x%02x", $r, $g, $b);
                                
                                if (!isset($colorCounts[$hexColor])) {
                                    $colorCounts[$hexColor] = 0;
                                }
                                $colorCounts[$hexColor]++;
                            }
                        }
                        
                        // Sort and get top colors
                        arsort($colorCounts);
                        $dominantColors = array_slice(array_keys($colorCounts), 0, 6);
                        
                        imagedestroy($image);
                    }
                } catch (Exception $e) {
                    $errorMsg = "Error processing image: " . $e->getMessage();
                }
            }
        } catch (Exception $e) {
            $errorMsg = "Error fetching image: " . $e->getMessage();
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image to Color Tool - InfinityToolSpace</title>
    <meta name="description" content="Extract dominant and palette colors from any image using our free image to color tool. Upload an image to get precise HEX, RGB, and HSL color codes.">
    <meta name="keywords" content="image to color, extract color from image, get hex from image, color picker from image, image color extractor, photo color tool, get RGB from image">
    <link rel="canonical" href="https://infinitytoolspace.com/tools/image-color" />
    
    <meta property="og:title" content="Image to Color - Extract Colors from Any Image Online" />
<meta property="og:description" content="Upload an image and instantly get dominant HEX, RGB, and HSL colors. Free image to color extractor tool for designers and developers." />
<meta property="og:url" content="https://infinitytoolspace.com/tools/image-color" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiqbneLly8QvG3hzjgXAtJzoZL2owpnikdN33s3TTeqdyLzKgRa5dszQdrEu9Ks06heKH1MSFRFWfhcADjeg-D3_l6cgtiKj00wuCN4TQfTAsrC2uOr6KTmo247fMS3fFSuXqC89zir0Dt3jhyNHPNfq4hO5ht_1YpIBg8kLQl0IumpqvBn2NGuKz81Rt0/s16000/image%20to%20color.jpg" />


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
    --primary-color: #5e72e4;
    --secondary-color: #7795f8;
    --accent-color: #3c54cc;
    --light-bg: #f8f9fe;
    --dark-bg: #172b4d;
    --card-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    --hover-shadow: 0 14px 26px rgba(50, 50, 93, 0.15), 0 8px 9px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s ease;
}

body {
    font-family: 'Inter', 'Segoe UI', sans-serif;
    background-color: var(--light-bg);
    min-height: 100vh;
    color: #525f7f;
}

.site-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 3rem 0;
    text-align: center;
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
}

.site-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    z-index: 1;
    pointer-events: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .site-header {
        padding: 2rem 0;
    }
    
    .upload-container {
        padding: 1.5rem;
        margin-top: -2rem;
    }
    
    .drop-zone {
        padding: 2rem 1rem;
    }
    
    .drop-zone i {
        font-size: 2.5rem;
    }
    
    .image-preview {
        max-height: 300px;
    }
    
    .image-preview img {
        max-height: 300px;
    }
    
    .color-swatch {
        height: 80px;
    }
    
    .color-details {
        padding: 1.5rem;
    }
    
    .color-info .color-preview {
        width: 50px;
        height: 50px;
    }
}

@media (max-width: 480px) {
    .site-header h1 {
        font-size: 1.75rem;
    }
    
    .color-palette {
        flex-wrap: wrap;
    }
    
    .color-swatch {
        flex: 0 0 33.333%;
        height: 60px;
    }
    
    .color-info {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .color-info .color-preview {
        margin-bottom: 1rem;
        margin-right: 0;
    }
    
    .similar-color {
        width: 30px;
        height: 30px;
    }
}

.site-header h1 {
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 2;
}

.site-header p {
    opacity: 0.9;
    font-weight: 300;
    position: relative;
    z-index: 2;
}

.upload-container {
    background-color: white;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: var(--card-shadow);
    transition: var(--transition);
    margin-top: -3rem;
    position: relative;
    z-index: 10;
}

.upload-container:hover {
    box-shadow: var(--hover-shadow);
}

.nav-tabs {
    border-bottom: 1px solid #e9ecef;
}

.nav-tabs .nav-link {
    border: 0;
    color: #8898aa;
    font-weight: 500;
    padding: 0.75rem 1rem;
    position: relative;
    transition: var(--transition);
}

.nav-tabs .nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background-color: var(--primary-color);
    transition: var(--transition);
}

.nav-tabs .nav-link.active {
    color: var(--primary-color);
    border: 0;
    background: none;
}

.nav-tabs .nav-link.active::after {
    width: 100%;
}

.nav-tabs .nav-link:hover:not(.active) {
    color: var(--primary-color);
}

.drop-zone {
    border: 2px dashed #e9ecef;
    border-radius: 12px;
    padding: 3rem 1rem;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    background-color: #fbfbfd;
}

.drop-zone:hover, .drop-zone.dragover {
    border-color: var(--primary-color);
    background-color: rgba(94, 114, 228, 0.05);
}

.drop-zone i {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
    filter: drop-shadow(0 4px 6px rgba(94, 114, 228, 0.3));
}

.url-input-container {
    padding: 1.5rem;
    background-color: #fbfbfd;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.input-group-text {
    background-color: var(--primary-color);
    color: white;
    border: none;
}

.btn-upload {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 0.75rem 1.75rem;
    border-radius: 8px;
    font-weight: 600;
    transition: var(--transition);
    box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
}

.btn-upload:hover {
    background-color: var(--accent-color);
    transform: translateY(-1px);
    box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
}

.btn-upload:active {
    transform: translateY(1px);
}

.image-preview {
    position: relative;
    margin-top: 2rem;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    background-color: #f8f9fe;
    max-height: 400px;
}

.image-preview:hover {
    box-shadow: var(--hover-shadow);
}

.image-preview img {
    width: 100%;
    height: auto;
    max-height: 400px;
    object-fit: contain;
    display: block;
}

.color-palette {
    display: flex;
    margin-top: 2rem;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--card-shadow);
}

.color-swatch {
    flex: 1;
    height: 100px;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
}

.color-swatch:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    z-index: 10;
}

.color-swatch::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 25px;
    background: linear-gradient(to top, rgba(0,0,0,0.2), transparent);
    opacity: 0;
    transition: var(--transition);
}

.color-swatch:hover::after {
    opacity: 1;
}

.color-details {
    background-color: white;
    border-radius: 16px;
    padding: 2rem;
    margin-top: 2rem;
    box-shadow: var(--card-shadow);
}

.color-info {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}

.color-info .color-preview {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    margin-right: 1.5rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: var(--transition);
}

.color-info .color-preview:hover {
    transform: scale(1.05);
}

.color-values {
    flex: 1;
}

.color-value-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.color-code {
    font-family: 'Roboto Mono', monospace;
    background-color: #f0f2f5;
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.9rem;
    color: #606b7c;
}

.copy-btn {
    background-color: #f0f2f5;
    border: none;
    color: var(--primary-color);
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    transition: var(--transition);
}

.copy-btn:hover {
    background-color: rgba(94, 114, 228, 0.1);
    color: var(--accent-color);
}

.similar-colors {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-top: 1.5rem;
}

.similar-color {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.similar-color:hover {
    transform: scale(1.15);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.toast-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <h1><i class="fas fa-palette me-2"></i>Image to Color Tool - InfinityToolSpace</h1>
            <p class="mb-0">Extract colors, generate palettes, and get color codes from any image</p>
        </div>
    </header>
    
    <div class="container py-5">
       <div class="row">
           <div class="col-lg-8 mx-auto">
               <div class="upload-container">
                   <h2 class="text-center mb-4">Upload Your Image</h2>
                   
                   <?php if ($errorMsg): ?>
                   <div class="alert alert-danger" role="alert">
                       <?php echo $errorMsg; ?>
                   </div>
                   <?php endif; ?>
                   
                   <form action="" method="post" enctype="multipart/form-data" id="uploadForm">
    <ul class="nav nav-tabs mb-3" id="uploadTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-tab-pane" type="button" role="tab" aria-controls="upload-tab-pane" aria-selected="true">Upload Image</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="url-tab" data-bs-toggle="tab" data-bs-target="#url-tab-pane" type="button" role="tab" aria-controls="url-tab-pane" aria-selected="false">Image URL</button>
        </li>
    </ul>
    
    <div class="tab-content" id="uploadTabContent">
        <div class="tab-pane fade show active" id="upload-tab-pane" role="tabpanel" aria-labelledby="upload-tab" tabindex="0">
            <div class="drop-zone" id="dropZone">
                <i class="fas fa-cloud-upload-alt"></i>
                <p class="mb-2">Drag & drop your image here</p>
                <p class="text-muted mb-3">or</p>
                <label for="imageUpload" class="btn btn-upload">Choose File</label>
                <input type="file" name="imageUpload" id="imageUpload" accept="image/*" style="display:none;">
            </div>
        </div>
        
        <div class="tab-pane fade" id="url-tab-pane" role="tabpanel" aria-labelledby="url-tab" tabindex="0">
            <div class="url-input-container">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                    <input type="url" class="form-control" id="imageUrl" name="imageUrl" placeholder="https://example.com/image.jpg">
                </div>
                <p class="text-muted small">Enter the direct URL to an image (JPG, PNG, WebP)</p>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-3">
        <button type="submit" class="btn btn-upload px-4"><i class="fas fa-search me-2"></i>Extract Colors</button>
    </div>
</form>
               </div>
               
               <?php if ($uploadedImage): ?>
               <div class="image-preview mt-5" id="imageContainer">
                   <img src="<?php echo $uploadedImage; ?>" alt="Uploaded image" id="previewImage">
                   <div class="color-picker-indicator" id="colorPickerIndicator" style="display:none;"></div>
               </div>
               
               <div class="color-palette" id="colorPalette">
                   <?php foreach ($dominantColors as $color): ?>
                   <div class="color-swatch" 
                        style="background-color: <?php echo $color; ?>;" 
                        data-color="<?php echo $color; ?>"
                        data-bs-toggle="tooltip" 
                        title="Click to select">
                   </div>
                   <?php endforeach; ?>
               </div>
               
               <div class="color-details mt-4" id="colorDetails">
                   <h3 class="mb-4">Color Details</h3>
                   <div id="colorDetailsContent">
                       <div class="text-center py-4">
                           <p>Click on a color in the palette above or directly on the image to see details</p>
                       </div>
                   </div>
               </div>
               <?php endif; ?>
           </div>
       </div>
       
       <!-- Features Section -->
       <?php if (!$uploadedImage): ?>
       <div class="row mt-5 pt-5">
           <div class="col-12 text-center mb-5">
               <h2>Key Features</h2>
               <p class="text-muted">Everything you need to extract and work with colors from images</p>
           </div>
           
           <div class="col-md-4 mb-4">
               <div class="feature-card">
                   <div class="text-center">
                       <div class="feature-icon">
                           <i class="fas fa-image"></i>
                       </div>
                       <h3>Upload Any Image</h3>
                       <p>Support for JPG, PNG, WebP, and other common formats</p>
                   </div>
               </div>
           </div>
           
           <div class="col-md-4 mb-4">
               <div class="feature-card">
                   <div class="text-center">
                       <div class="feature-icon">
                           <i class="fas fa-magic"></i>
                       </div>
                       <h3>Extract Dominant Colors</h3>
                       <p>Automatically identify key colors from any image</p>
                   </div>
               </div>
           </div>
           
           <div class="col-md-4 mb-4">
               <div class="feature-card">
                   <div class="text-center">
                       <div class="feature-icon">
                           <i class="fas fa-paint-brush"></i>
                       </div>
                       <h3>Generate Color Palettes</h3>
                       <p>Create harmonious color schemes from your images</p>
                   </div>
               </div>
           </div>
           
           <div class="col-md-4 mb-4">
               <div class="feature-card">
                   <div class="text-center">
                       <div class="feature-icon">
                           <i class="fas fa-code"></i>
                       </div>
                       <h3>Color Formats</h3>
                       <p>Get HEX, RGB, and HSL values for all colors</p>
                   </div>
               </div>
           </div>
           
           <div class="col-md-4 mb-4">
               <div class="feature-card">
                   <div class="text-center">
                       <div class="feature-icon">
                           <i class="fas fa-copy"></i>
                       </div>
                       <h3>Copy to Clipboard</h3>
                       <p>Instantly copy color codes with a single click</p>
                   </div>
               </div>
           </div>
           
           <div class="col-md-4 mb-4">
               <div class="feature-card">
                   <div class="text-center">
                       <div class="feature-icon">
                           <i class="fas fa-eye-dropper"></i>
                       </div>
                       <h3>Color Picker</h3>
                       <p>Pick specific colors directly from your image</p>
                   </div>
               </div>
           </div>
       </div>
       <?php endif; ?>
   </div>
   
   <footer>
       <div class="container">
           <div class="row">
               <div class="col-md-6">
                   <h3>Image to Color Tool</h3>
                   <p>A free online tool to extract colors from images, generate color palettes, and get color codes in various formats.</p>
               </div>
               <div class="col-md-3">
                   <h4>Features</h4>
                   <ul class="list-unstyled">
                       <li>• Upload Images</li>
                       <li>• Extract Colors</li>
                       <li>• Color Palette Generation</li>
                       <li>• HEX & RGB Values</li>
                       <li>• Copy to Clipboard</li>
                   </ul>
               </div>
               <div class="col-md-3">
                   <h4>Uses</h4>
                   <ul class="list-unstyled">
                       <li>• Web Design</li>
                       <li>• Graphic Design</li>
                       <li>• Interior Design</li>
                       <li>• Brand Development</li>
                       <li>• Art & Illustration</li>
                   </ul>
               </div>
           </div>
           <hr class="mt-4 mb-3">
           <div class="text-center">
               <p>&copy; <?php echo date('Y'); ?> Image to Color Tool - InfinityToolSpace. All rights reserved.</p>
           </div>
       </div>
   </footer>
   
   <div class="toast-container" id="toastContainer"></div>
   
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script>
       document.addEventListener('DOMContentLoaded', function() {
           // Initialize Bootstrap tooltips
           var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
           var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
               return new bootstrap.Tooltip(tooltipTriggerEl);
           });
           
           // File upload functionality
           const dropZone = document.getElementById('dropZone');
           const imageUpload = document.getElementById('imageUpload');
           
           if (dropZone && imageUpload) {
               // Handle drag and drop events
               ['dragover', 'dragenter'].forEach(eventName => {
                   dropZone.addEventListener(eventName, function(e) {
                       e.preventDefault();
                       dropZone.classList.add('dragover');
                   });
               });
               
               ['dragleave', 'dragend', 'drop'].forEach(eventName => {
                   dropZone.addEventListener(eventName, function(e) {
                       e.preventDefault();
                       dropZone.classList.remove('dragover');
                   });
               });
               
               dropZone.addEventListener('drop', function(e) {
                   e.preventDefault();
                   if (e.dataTransfer.files.length) {
                       imageUpload.files = e.dataTransfer.files;
                       document.getElementById('uploadForm').submit();
                   }
               });
               
               dropZone.addEventListener('click', function() {
                   imageUpload.click();
               });
               
               imageUpload.addEventListener('change', function() {
                   if (imageUpload.files.length) {
                       document.getElementById('uploadForm').submit();
                   }
               });
           }
           
           // Color palette interaction
           const colorPalette = document.getElementById('colorPalette');
           const colorDetails = document.getElementById('colorDetailsContent');
           
           if (colorPalette && colorDetails) {
               const colorSwatches = colorPalette.querySelectorAll('.color-swatch');
               
               colorSwatches.forEach(swatch => {
                   swatch.addEventListener('click', function() {
                       const hexColor = this.dataset.color;
                       showColorDetails(hexColor);
                   });
               });
           }
           
           // Image color picker functionality
           // Image color picker functionality
const imageContainer = document.getElementById('imageContainer');
const previewImage = document.getElementById('previewImage');

if (imageContainer && previewImage) {
    // Create an offscreen canvas for color picking
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    
    // Create color picker indicator if it doesn't exist
    let colorPickerIndicator = document.getElementById('colorPickerIndicator');
    if (!colorPickerIndicator) {
        colorPickerIndicator = document.createElement('div');
        colorPickerIndicator.id = 'colorPickerIndicator';
        colorPickerIndicator.className = 'color-picker-indicator';
        imageContainer.appendChild(colorPickerIndicator);
    }
    
    // Style for the color picker indicator
    colorPickerIndicator.style.position = 'absolute';
    colorPickerIndicator.style.width = '20px';
    colorPickerIndicator.style.height = '20px';
    colorPickerIndicator.style.borderRadius = '50%';
    colorPickerIndicator.style.boxShadow = '0 0 0 2px white, 0 0 0 3px #000';
    colorPickerIndicator.style.pointerEvents = 'none';
    colorPickerIndicator.style.zIndex = '10';
    colorPickerIndicator.style.display = 'none';
    
    previewImage.onload = function() {
        canvas.width = previewImage.naturalWidth;
        canvas.height = previewImage.naturalHeight;
        ctx.drawImage(previewImage, 0, 0);
    };
    
    // Handle mouse movement for color picking
    imageContainer.addEventListener('mousemove', function(e) {
        if (!previewImage.complete) return;
        
        const rect = previewImage.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        // Calculate position relative to the actual image (accounting for object-fit)
        const imageWidth = previewImage.width;
        const imageHeight = previewImage.height;
        
        // Check if mouse is within image boundaries
        if (x >= 0 && y >= 0 && x <= imageWidth && y <= imageHeight) {
            // Scale coordinates to match canvas/original image dimensions
            const canvasX = (x / imageWidth) * canvas.width;
            const canvasY = (y / imageHeight) * canvas.height;
            
            // Show color picker indicator
            colorPickerIndicator.style.display = 'block';
            colorPickerIndicator.style.left = `${x - 10}px`;
            colorPickerIndicator.style.top = `${y - 10}px`;
            
            // Get color at position
            try {
                const pixel = ctx.getImageData(canvasX, canvasY, 1, 1).data;
                const color = `#${((1 << 24) + (pixel[0] << 16) + (pixel[1] << 8) + pixel[2]).toString(16).slice(1)}`;
                colorPickerIndicator.style.backgroundColor = color;
                
                // Display current color in a tooltip or info box
                colorPickerIndicator.setAttribute('data-current-color', color);
            } catch (e) {
                // Handle potential canvas security error (when loading cross-origin images)
                console.log("Canvas error:", e);
            }
        } else {
            colorPickerIndicator.style.display = 'none';
        }
    });
    
    // Handle click for color selection
    imageContainer.addEventListener('click', function(e) {
        if (!previewImage.complete || colorPickerIndicator.style.display === 'none') return;
        
        const currentColor = colorPickerIndicator.getAttribute('data-current-color');
        if (currentColor) {
            showColorDetails(currentColor);
        }
    });
    
    // Handle mouse leave
    imageContainer.addEventListener('mouseleave', function() {
        colorPickerIndicator.style.display = 'none';
    });
}
           
           // Function to generate similar colors (shades and tints)
           function generateSimilarColors(hexColor) {
               // Convert hex to RGB
               const rgb = hexToRgb(hexColor);
               
               // Generate variations
               const variations = [];
               
               // Shades (darker)
               for (let i = 1; i <= 3; i++) {
                   const factor = 1 - (i * 0.15);
                   const shade = {
                       r: Math.round(rgb.r * factor),
                       g: Math.round(rgb.g * factor),
                       b: Math.round(rgb.b * factor)
                   };
                   variations.push(rgbToHex(shade.r, shade.g, shade.b));
               }
               
               // Tints (lighter)
               for (let i = 1; i <= 3; i++) {
                   const factor = i * 0.15;
                   const tint = {
                       r: Math.round(rgb.r + (255 - rgb.r) * factor),
                       g: Math.round(rgb.g + (255 - rgb.g) * factor),
                       b: Math.round(rgb.b + (255 - rgb.b) * factor)
                   };
                   variations.push(rgbToHex(tint.r, tint.g, tint.b));
               }
               
               return variations;
           }
           
           // Helper functions for color conversions
           function hexToRgb(hex) {
               const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
               return result ? {
                   r: parseInt(result[1], 16),
                   g: parseInt(result[2], 16),
                   b: parseInt(result[3], 16)
               } : null;
           }
           
           function rgbToHex(r, g, b) {
               r = Math.max(0, Math.min(255, r));
               g = Math.max(0, Math.min(255, g));
               b = Math.max(0, Math.min(255, b));
               return `#${((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1)}`;
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
           
           // Display color details
           function showColorDetails(hexColor) {
               const rgb = hexToRgb(hexColor);
               const hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
               const similarColors = generateSimilarColors(hexColor);
               
               const htmlContent = `
                   <div class="color-info">
                       <div class="color-preview" style="background-color: ${hexColor};"></div>
                       <div class="color-values">
                           <div class="color-value-item">
                               <span>HEX:</span>
                               <div class="d-flex align-items-center">
                                   <span class="color-code">${hexColor}</span>
                                   <button class="copy-btn ms-2" data-value="${hexColor}">
                                       <i class="fas fa-copy"></i>
                                   </button>
                               </div>
                           </div>
                           <div class="color-value-item">
                               <span>RGB:</span>
                               <div class="d-flex align-items-center">
                                   <span class="color-code">rgb(${rgb.r}, ${rgb.g}, ${rgb.b})</span>
                                   <button class="copy-btn ms-2" data-value="rgb(${rgb.r}, ${rgb.g}, ${rgb.b})">
                                       <i class="fas fa-copy"></i>
                                   </button>
                               </div>
                           </div>
                           <div class="color-value-item">
                               <span>HSL:</span>
                               <div class="d-flex align-items-center">
                                   <span class="color-code">hsl(${hsl.h}, ${hsl.s}%, ${hsl.l}%)</span>
                                   <button class="copy-btn ms-2" data-value="hsl(${hsl.h}, ${hsl.s}%, ${hsl.l}%)">
                                       <i class="fas fa-copy"></i>
                                   </button>
                               </div>
                           </div>
                       </div>
                   </div>
                   
                   <h4 class="mt-4 mb-3">Similar Colors</h4>
                   <div class="similar-colors">
                       ${similarColors.map(color => `
                           <div class="similar-color" 
                                style="background-color: ${color};" 
                                data-color="${color}"
                                data-bs-toggle="tooltip" 
                                title="${color}">
                           </div>
                       `).join('')}
                   </div>
               `;
               
               colorDetails.innerHTML = htmlContent;
               
               // Initialize tooltips for new elements
               var tooltipTriggerList = [].slice.call(colorDetails.querySelectorAll('[data-bs-toggle="tooltip"]'));
               var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                   return new bootstrap.Tooltip(tooltipTriggerEl);
               });
               
               // Add event listeners for copy buttons
               const copyButtons = colorDetails.querySelectorAll('.copy-btn');
               copyButtons.forEach(button => {
                   button.addEventListener('click', function() {
                       const value = this.dataset.value;
                       copyToClipboard(value);
                       showToast('Copied to clipboard!');
                   });
               });
               
               // Add event listeners for similar colors
               const similarColorElements = colorDetails.querySelectorAll('.similar-color');
               similarColorElements.forEach(element => {
                   element.addEventListener('click', function() {
                       const color = this.dataset.color;
                       showColorDetails(color);
                   });
               });
           }
           
           // Copy to clipboard function
           function copyToClipboard(text) {
               const tempInput = document.createElement('input');
               tempInput.value = text;
               document.body.appendChild(tempInput);
               tempInput.select();
               document.execCommand('copy');
               document.body.removeChild(tempInput);
           }
           
           // Show toast notification
           function showToast(message) {
               const toastContainer = document.getElementById('toastContainer');
               const toast = document.createElement('div');
               toast.className = 'toast-notification';
               toast.innerHTML = `
                   <i class="fas fa-check-circle"></i>
                   <span>${message}</span>
               `;
               
               toastContainer.appendChild(toast);
               
               // Force reflow to enable animation
               toast.offsetHeight;
               
               toast.classList.add('show');
               
               setTimeout(() => {
                   toast.classList.remove('show');
                   setTimeout(() => {
                       toastContainer.removeChild(toast);
                   }, 300);
               }, 3000);
           }
       });
   </script>
   
   <!-- SEO Optimization -->
   <script type="application/ld+json">
   {
       "@context": "https://schema.org",
       "@type": "WebApplication",
       "name": "Image to Color Tool",
       "description": "Extract HEX, RGB, and HSL color codes from any image. Free tool for designers and developers to quickly get image colors.",
       "applicationCategory": "DesignApplication",
       "operatingSystem": "All",
       "offers": {
           "@type": "Offer",
           "price": "0",
           "priceCurrency": "USD"
       },
       "featureList": [
           "Upload Image",
           "Extract Colors",
           "Color Palette Generation",
           "HEX & RGB Values",
           "Copy to Clipboard",
           "Color Picker from Image"
       ]
   }
   </script>
</body>
</html>