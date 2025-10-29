<?php
// Start session at the very beginning of the script
session_start();

// Add this code near the beginning, after session_start()
if (isset($_GET['reset']) && $_GET['reset'] == '1') {
    // Clear the session variables related to image processing
    unset($_SESSION['image']);
    unset($_SESSION['originalFileName']);
    unset($_SESSION['origWidth']);
    unset($_SESSION['origHeight']);
    unset($_SESSION['resizedImages']);
    unset($_SESSION['zipFile']);
    
    // Redirect to the same page without the query parameter
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}


// Add this function near the top of your file, after session_start()

/**
 * Schedule file for deletion after specified minutes
 * @param string $filepath Path to the file
 * @param int $minutes Minutes after which file should be deleted
 */
function scheduleFileForDeletion($filepath, $minutes = 25) {
    if (!file_exists($filepath)) return;
    
    // Create a file metadata record
    $metaFile = 'file_metadata.json';
    $metadata = [];
    
    if (file_exists($metaFile)) {
        $jsonContent = file_get_contents($metaFile);
        $metadata = json_decode($jsonContent, true) ?: [];
    }
    
    // Add expiration time for this file
    $metadata[$filepath] = time() + ($minutes * 60);
    
    // Save metadata
    file_put_contents($metaFile, json_encode($metadata));
}

/**
 * Clean up expired files
 */
function cleanupExpiredFiles() {
    $metaFile = 'file_metadata.json';
    if (!file_exists($metaFile)) return;
    
    $jsonContent = file_get_contents($metaFile);
    $metadata = json_decode($jsonContent, true) ?: [];
    $currentTime = time();
    $updated = false;
    
    foreach ($metadata as $filepath => $expirationTime) {
        if ($currentTime > $expirationTime) {
            // File has expired, delete it
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            unset($metadata[$filepath]);
            $updated = true;
        }
    }
    
    // Update metadata file if changes were made
    if ($updated) {
        file_put_contents($metaFile, json_encode($metadata));
    }
}

// Run cleanup on every page load
cleanupExpiredFiles();

// Add this code near the beginning for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Initialize variables
$uploaded = false;
$error = "";
$resizedImages = [];
$originalImage = null;
$focalPointX = 50;
$focalPointY = 50;
$customWidth = 1200;
$customHeight = 630;

// Define social media image sizes
$socialMediaSizes = [
    'facebook' => [
        'Profile Image' => ['width' => 180, 'height' => 180],
        'Cover Photo' => ['width' => 820, 'height' => 312],
        'Shared Image' => ['width' => 1200, 'height' => 630],
        'Event Image' => ['width' => 1920, 'height' => 1005],
    ],
    'instagram' => [
        'Profile Image' => ['width' => 320, 'height' => 320],
        'Post' => ['width' => 1080, 'height' => 1080],
        'Story' => ['width' => 1080, 'height' => 1920],
        'Landscape' => ['width' => 1080, 'height' => 566],
        'Portrait' => ['width' => 1080, 'height' => 1350],
    ],
    'twitter' => [
        'Profile Photo' => ['width' => 400, 'height' => 400],
        'Header Photo' => ['width' => 1500, 'height' => 500],
        'In-Stream Photo' => ['width' => 1600, 'height' => 900],
    ],
    'linkedin' => [
        'Profile Photo' => ['width' => 400, 'height' => 400],
        'Cover Photo' => ['width' => 1584, 'height' => 396],
        'Shared Image' => ['width' => 1200, 'height' => 627],
        'Company Logo' => ['width' => 300, 'height' => 300],
    ],
    'pinterest' => [
        'Profile Image' => ['width' => 165, 'height' => 165],
        'Pin Image' => ['width' => 1000, 'height' => 1500],
        'Board Cover' => ['width' => 800, 'height' => 800],
    ],
    'youtube' => [
        'Channel Profile' => ['width' => 800, 'height' => 800],
        'Channel Cover' => ['width' => 2560, 'height' => 1440],
        'Thumbnail' => ['width' => 1280, 'height' => 720],
    ],
    'tiktok' => [
        'Profile Photo' => ['width' => 200, 'height' => 200],
        'Video Cover' => ['width' => 1080, 'height' => 1920],
    ],
];

// Process image upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['process_type']) && $_POST['process_type'] == 'upload' && isset($_FILES["image"])) {
        if ($_FILES["image"]["error"] == 0) {
            $targetDir = "uploads/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            
            $originalName = basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $uniqueName = uniqid() . '.' . $imageFileType;
            $targetFile = $targetDir . $uniqueName;
            
            // Check if file is an actual image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                // Check file size (limited to 10MB)
                if ($_FILES["image"]["size"] < 10000000) {
                    // Allow only certain file formats
                    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                            $uploaded = true;
                            $_SESSION['image'] = $targetFile;
                            $_SESSION['originalFileName'] = $originalName;
                            
                                scheduleFileForDeletion($targetFile, 25);

                            // Get image dimensions
                            list($origWidth, $origHeight) = getimagesize($targetFile);
                            $_SESSION['origWidth'] = $origWidth;
                            $_SESSION['origHeight'] = $origHeight;
                            
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit;
                        } else {
                            $error = "Sorry, there was an error uploading your file.";
                        }
                    } else {
                        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    }
                } else {
                    $error = "Sorry, your file is too large (max 10MB).";
                }
            } else {
                $error = "File is not an image.";
            }
        } else {
            $error = "Error: " . $_FILES["image"]["error"];
        }
    } elseif (isset($_POST['process_type']) && $_POST['process_type'] == 'resize') {
        // Process resize with focal point
        if (isset($_SESSION['image']) && file_exists($_SESSION['image'])) {
            $focalPointX = isset($_POST['focalPointX']) ? floatval($_POST['focalPointX']) : 50;
            $focalPointY = isset($_POST['focalPointY']) ? floatval($_POST['focalPointY']) : 50;
            $customWidth = isset($_POST['customWidth']) ? intval($_POST['customWidth']) : 1200;
            $customHeight = isset($_POST['customHeight']) ? intval($_POST['customHeight']) : 630;
            
            $selectedPlatforms = [];
            foreach ($socialMediaSizes as $platform => $sizes) {
                if (isset($_POST[$platform]) && $_POST[$platform] == 'on') {
                    $selectedPlatforms[] = $platform;
                }
            }
            
            if (empty($selectedPlatforms)) {
                $selectedPlatforms = array_keys($socialMediaSizes);
            }
            
            $resizedDir = "resized/";
            if (!file_exists($resizedDir)) {
                mkdir($resizedDir, 0777, true);
            }
            
            // Clear previous resized images if any
            array_map('unlink', glob($resizedDir . '*'));
            
            // Create ZIP archive
            $zipFile = 'resized_images_' . date('YmdHis') . '.zip';
            $zip = new ZipArchive();
            if ($zip->open($resizedDir . $zipFile, ZipArchive::CREATE) !== TRUE) {
                $error = "Cannot create zip file";
            }
            
            // Also create custom size
            if (isset($_POST['custom_resize']) && $_POST['custom_resize'] == 'on') {
                $customResizedFile = resizeImageWithFocalPoint(
                    $_SESSION['image'],
                    $resizedDir . "custom_{$customWidth}x{$customHeight}.jpg",
                    $customWidth,
                    $customHeight,
                    $focalPointX,
                    $focalPointY
                );
                
                if ($customResizedFile) {
                    $resizedImages[] = [
                        'platform' => 'Custom Size',
                        'name' => "Custom {$customWidth}x{$customHeight}",
                        'file' => basename($customResizedFile),
                        'width' => $customWidth,
                        'height' => $customHeight
                    ];
                    
                    $zip->addFile($customResizedFile, "custom_{$customWidth}x{$customHeight}.jpg");
                    
                        scheduleFileForDeletion($customResizedFile, 25);

                }
            }
            
            // Process selected platforms
            foreach ($selectedPlatforms as $platform) {
                foreach ($socialMediaSizes[$platform] as $name => $size) {
                    $width = $size['width'];
                    $height = $size['height'];
                    $outputFile = $resizedDir . strtolower(str_replace(' ', '_', $platform . '_' . $name)) . '.jpg';
                    
                    $resizedFile = resizeImageWithFocalPoint(
                        $_SESSION['image'],
                        $outputFile,
                        $width,
                        $height,
                        $focalPointX,
                        $focalPointY
                    );
                    
                    if ($resizedFile) {
                        $resizedImages[] = [
                            'platform' => $platform,
                            'name' => $name,
                            'file' => basename($resizedFile),
                            'width' => $width,
                            'height' => $height
                        ];
                        
                        $zip->addFile($resizedFile, strtolower(str_replace(' ', '_', $platform . '_' . $name)) . '.jpg');
                        
                            scheduleFileForDeletion($resizedFile, 25);

                    }
                }
            }
            
            $zip->close();
            $_SESSION['zipFile'] = $resizedDir . $zipFile;
            $_SESSION['resizedImages'] = $resizedImages;
            
            scheduleFileForDeletion($resizedDir . $zipFile, 25);

            
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

// Load image from session if it exists
if (isset($_SESSION['image']) && file_exists($_SESSION['image'])) {
    $originalImage = $_SESSION['image'];
    $uploaded = true;
    
    if (isset($_SESSION['resizedImages'])) {
        $resizedImages = $_SESSION['resizedImages'];
    }
}

/**
 * Resize image while maintaining focus on specific point
 */
function resizeImageWithFocalPoint($sourceFile, $targetFile, $newWidth, $newHeight, $focalPointX, $focalPointY) {
    // Load the original image
    $sourceImage = imagecreatefromstring(file_get_contents($sourceFile));
    if (!$sourceImage) {
        return false;
    }
    
    // Get the original image dimensions
    $origWidth = imagesx($sourceImage);
    $origHeight = imagesy($sourceImage);
    
    // Convert focal point from percentage to pixels
    $focalX = $origWidth * ($focalPointX / 100);
    $focalY = $origHeight * ($focalPointY / 100);
    
    // Calculate aspect ratios
    $origAspect = $origWidth / $origHeight;
    $newAspect = $newWidth / $newHeight;
    
    // Calculate dimensions for cropping
    if ($origAspect > $newAspect) {
        // Original image is wider than new aspect ratio
        $cropHeight = $origHeight;
        $cropWidth = $origHeight * $newAspect;
        
        // Calculate crop position based on focal point
        $cropX = max(0, min($origWidth - $cropWidth, $focalX - ($cropWidth / 2)));
    } else {
        // Original image is taller than new aspect ratio
        $cropWidth = $origWidth;
        $cropHeight = $origWidth / $newAspect;
        
        // Calculate crop position based on focal point
        $cropY = max(0, min($origHeight - $cropHeight, $focalY - ($cropHeight / 2)));
    }
    
    // Create new image with desired dimensions
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    
    // Preserve transparency for PNG images
    if (exif_imagetype($sourceFile) == IMAGETYPE_PNG) {
        imagecolortransparent($newImage, imagecolorallocate($newImage, 0, 0, 0));
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
    }
    
    // Crop and resize the image
    if ($origAspect > $newAspect) {
        // Crop width
        imagecopyresampled(
            $newImage, $sourceImage,
            0, 0, $cropX, 0,
            $newWidth, $newHeight, $cropWidth, $cropHeight
        );
    } else {
        // Crop height
        imagecopyresampled(
            $newImage, $sourceImage,
            0, 0, 0, $cropY,
            $newWidth, $newHeight, $cropWidth, $cropHeight
        );
    }
    
    // Save the new image
    if (imagejpeg($newImage, $targetFile, 90)) {
        imagedestroy($sourceImage);
        imagedestroy($newImage);
        return $targetFile;
    }
    
    imagedestroy($sourceImage);
    imagedestroy($newImage);
    return false;
}

// Start session if not already started
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

function humanFileSize($size, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $step = 1024;
    $i = 0;
    while (($size / $step) > 0.9) {
        $size = $size / $step;
        $i++;
    }
    return round($size, $precision) . ' ' . $units[$i];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Image Resizer | Automatically Resize Images for All Platforms</title>
    <meta name="description" content="Free online tool to resize images for every social media platform. Resize for Facebook, Instagram, Twitter, LinkedIn, and more with custom focal points.">
    <meta name="keywords" content="image resizer, resize image online, free image resizer, jpg resizer, png resizer, compress and resize, online photo resizer, web image resizer, resize photo">
    <link rel="canonical" href="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />

    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:title" content="Social Media Image Resizer">
    <meta property="og:description" content="Easily resize images online without losing quality. Supports JPG, PNG, WebP, and more. Free and fast online photo resizer tool.">
    <meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhXagzlD9XcxMfFbvG2NQmT9HeCXeuwiTqBtuWAWVYQHnVS6e5AJ3cAMS1UTUJBuV8knGz62CGou0ZFMuLD8qpf0tcULqLNHr_huMUkiTimiJQ7akx8P0Rmwe9qpHVyzlcYYDd_sthUIfSVQRrwcDpeDIawtRWuGzpdtXlDvVYP1pu69hZPDEwzOzIkM1E/s16000/word_counter.jpeg">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="twitter:title" content="Social Media Image Resizer">
    <meta property="twitter:description" content="Easily resize images online without losing quality. Supports JPG, PNG, WebP, and more. Free and fast online photo resizer tool.">
    <meta property="twitter:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhXagzlD9XcxMfFbvG2NQmT9HeCXeuwiTqBtuWAWVYQHnVS6e5AJ3cAMS1UTUJBuV8knGz62CGou0ZFMuLD8qpf0tcULqLNHr_huMUkiTimiJQ7akx8P0Rmwe9qpHVyzlcYYDd_sthUIfSVQRrwcDpeDIawtRWuGzpdtXlDvVYP1pu69hZPDEwzOzIkM1E/s16000/word_counter.jpeg">
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
    --primary-color: #4361ee;
    --primary-light: rgba(67, 97, 238, 0.1);
    --secondary-color: #10b981;
    --secondary-light: rgba(16, 185, 129, 0.1);
    --background-color: #f9fafb;
    --card-bg: #ffffff;
    --text-color: #374151;
    --text-muted: #6b7280;
    --border-color: #e5e7eb;
    --accent-color: #6366f1;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    background-color: var(--background-color);
    color: var(--text-color);
    font-family: 'Inter', 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    padding-top: 30px;
    padding-bottom: 60px;
    line-height: 1.6;
    font-size: 16px;
}

h1, h2, h3, h4, h5, h6 {
    font-weight: 700;
    margin-bottom: 1rem;
    color: #1e293b;
    line-height: 1.3;
}

h1 {
    font-size: 2.25rem;
    letter-spacing: -0.025em;
}

h2 {
    font-size: 1.875rem;
    letter-spacing: -0.025em;
}

.container {
    max-width: 1200px;
}

/* Card Styling */
.card {
    border-radius: 12px;
    border: none;
    box-shadow: var(--shadow);
    margin-bottom: 28px;
    transition: var(--transition);
    overflow: hidden;
}

.card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.card-header {
    background-color: var(--card-bg);
    border-bottom: 1px solid var(--border-color);
    padding: 1.25rem 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    font-size: 1.125rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.card-header i, .card-header svg {
    margin-right: 8px;
    color: var(--primary-color);
}

.card-body {
    padding: 1.5rem;
    background-color: var(--card-bg);
}

/* Button Styling */
.btn {
    border-radius: 8px;
    padding: 0.5rem 1.25rem;
    font-weight: 600;
    font-size: 0.95rem;
    letter-spacing: 0.025em;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn i, .btn svg {
    font-size: 1.1em;
}

.btn-primary {
    background: linear-gradient(145deg, var(--primary-color), #3b56d9);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background: linear-gradient(145deg, #3b56d9, #2e4bd0);
    border-color: #2e4bd0;
    box-shadow: var(--shadow), 0 0 0 3px var(--primary-light);
    transform: translateY(-1px);
}

.btn-primary:focus {
    box-shadow: 0 0 0 4px var(--primary-light);
}

.btn-success {
    background: linear-gradient(145deg, var(--secondary-color), #0ea974);
    border-color: var(--secondary-color);
}

.btn-success:hover {
    background: linear-gradient(145deg, #0ea974, #0d9868);
    border-color: #0d9868;
    box-shadow: var(--shadow), 0 0 0 3px var(--secondary-light);
    transform: translateY(-1px);
}

.btn-success:focus {
    box-shadow: 0 0 0 4px var(--secondary-light);
}

/* Form Controls */
.form-control, .form-select {
    border-radius: 8px;
    padding: 0.65rem 1rem;
    border: 1px solid var(--border-color);
    font-size: 0.95rem;
    transition: var(--transition);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px var(--primary-light);
}

.form-label {
    font-weight: 600;
    color: #4b5563;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

/* Upload Box */
.upload-box {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 60px 30px;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    background-color: rgba(249, 250, 251, 0.5);
}

.upload-box:hover {
    border-color: var(--primary-color);
    background-color: var(--primary-light);
}

.upload-box i, .upload-box svg {
    font-size: 54px;
    color: #9ca3af;
    margin-bottom: 20px;
    transition: var(--transition);
}

.upload-box:hover i, .upload-box:hover svg {
    color: var(--primary-color);
    transform: scale(1.05);
}

.upload-box p {
    color: var(--text-muted);
    font-weight: 500;
    margin-bottom: 0;
}

.upload-box .upload-text {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 6px;
    font-size: 1.25rem;
}

/* Image preview and focal point selector */
#imagePreviewContainer {
    position: relative;
    max-width: 100%;
    overflow: hidden;
    margin: 0 auto;
    border-radius: 8px;
    box-shadow: var(--shadow);
}

#imagePreview {
    width: 100%;
    height: auto;
    display: block;
    transition: var(--transition);
}

#focalPoint {
    position: absolute;
    width: 36px;
    height: 36px;
    background-color: rgba(255, 255, 255, 0.85);
    border: 3px solid var(--primary-color);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    cursor: move;
    z-index: 10;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    transition: box-shadow 0.2s ease;
}

#focalPoint:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

#focalPoint:after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 8px;
    height: 8px;
    background-color: var(--primary-color);
    border-radius: 50%;
    transform: translate(-50%, -50%);
}

/* Resize results */
.resize-result {
    border: 1px solid var(--border-color);
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    transition: var(--transition);
    background-color: var(--card-bg);
    box-shadow: var(--shadow-sm);
}

.resize-result:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.resize-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.resize-title {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.download-btn {
    margin-top: 10px;
}

.platform-icon {
    font-size: 28px;
    margin-right: 12px;
    transition: transform 0.2s ease;
}

.resize-result:hover .platform-icon {
    transform: scale(1.1);
}

/* Custom platform color icons with refined colors */
.facebook { color: #1877f2; }
.instagram { color: #e4405f; }
.twitter { color: #1da1f2; }
.linkedin { color: #0a66c2; }
.pinterest { color: #e60023; }
.youtube { color: #ff0000; }
.tiktok { color: #000000; }

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

.slide-in {
    animation: slideIn 0.5s ease-out forwards;
}

.scale-in {
    animation: scaleIn 0.4s ease-out forwards;
}

/* Tab styles */
.nav-tabs {
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 1.5rem;
    gap: 0.5rem;
}

.nav-tabs .nav-link {
    color: var(--text-muted);
    font-weight: 600;
    border: none;
    border-bottom: 2px solid transparent;
    padding: 0.75rem 1rem;
    border-radius: 8px 8px 0 0;
    transition: var(--transition);
    margin-bottom: -1px;
}

.nav-tabs .nav-link.active {
    color: var(--primary-color);
    border-bottom: 2px solid var(--primary-color);
    background-color: transparent;
}

.nav-tabs .nav-link:hover:not(.active) {
    border-color: transparent;
    background-color: rgba(243, 244, 246, 0.7);
    color: #4b5563;
}

/* Loading spinner */
.spinner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(5px);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    visibility: hidden;
    opacity: 0;
    transition: all 0.3s;
}

.spinner-overlay.show {
    visibility: visible;
    opacity: 1;
}

.spinner-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.spinner {
    width: 48px;
    height: 48px;
    border: 4px solid rgba(67, 97, 238, 0.1);
    border-left-color: var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.spinner-text {
    margin-top: 16px;
    font-weight: 600;
    color: var(--text-color);
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Platform section */
.platform-section {
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    background-color: var(--card-bg);
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
}

.platform-section:hover {
    box-shadow: var(--shadow);
}

.platform-title {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.platform-title i, .platform-title svg {
    color: var(--primary-color);
}

/* Form switch */
.form-switch .form-check-input {
    width: 3.25em;
    height: 1.75em;
    margin-top: 0.15em;
    cursor: pointer;
    background-color: #e5e7eb;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='white'/%3e%3c/svg%3e");
    transition: background-position 0.15s ease-in-out, background-color 0.15s ease-in-out;
}

.form-switch .form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.form-switch .form-check-input:focus {
    box-shadow: 0 0 0 4px var(--primary-light);
    border-color: var(--primary-color);
}

.form-check-label {
    font-weight: 500;
    cursor: pointer;
    user-select: none;
}

/* Custom size input */
.custom-size-container {
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 20px;
    margin-top: 24px;
    background-color: var(--card-bg);
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
}

.custom-size-container:hover {
    box-shadow: var(--shadow);
}

.custom-size-container .form-label {
    color: #1e293b;
}

.size-group {
    display: flex;
    gap: 10px;
    align-items: center;
}

.size-group .form-control {
    width: 90px;
}

.dimension-label {
    color: var(--text-muted);
    font-weight: 500;
}

.x-separator {
    color: var(--text-muted);
    font-weight: 500;
    margin: 0 5px;
}

/* Footer */
footer {
    background-color: var(--card-bg);
    border-top: 1px solid var(--border-color);
    padding: 24px 0;
    margin-top: 60px;
    box-shadow: 0 -1px 10px rgba(0, 0, 0, 0.05);
}

footer p {
    margin-bottom: 0;
    color: var(--text-muted);
    font-size: 0.95rem;
}

footer a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

footer a:hover {
    color: #3b56d9;
    text-decoration: underline;
}

/* Mobile Optimization */
@media (max-width: 767px) {
    h1 {
        font-size: 1.875rem;
    }
    
    h2 {
        font-size: 1.5rem;
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    .upload-box {
        padding: 40px 20px;
    }
    
    .upload-box i, .upload-box svg {
        font-size: 42px;
    }
    
    .platform-title {
        font-size: 1.1rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .card-header {
        padding: 1rem 1.25rem;
    }
}

/* Additional Premium Features */

/* Tooltip */
.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip .tooltiptext {
    visibility: hidden;
    background-color: #1e293b;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 8px 12px;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s, transform 0.3s;
    font-size: 0.85rem;
    font-weight: 500;
    box-shadow: var(--shadow-md);
    width: max-content;
    max-width: 250px;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
    transform: translateX(-50%) translateY(-5px);
}

/* Badge */
.badge {
    display: inline-flex;
    align-items: center;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.35em 0.65em;
    border-radius: 0.375rem;
    letter-spacing: 0.025em;
}

.badge-primary {
    background-color: var(--primary-light);
    color: var(--primary-color);
}

.badge-secondary {
    background-color: var(--secondary-light);
    color: var(--secondary-color);
}

/* Aspect ratio badges */
.aspect-ratio-badge {
    background-color: rgba(243, 244, 246, 0.7);
    color: #4b5563;
    border-radius: 6px;
    padding: 5px 10px;
    font-size: 0.8rem;
    font-weight: 600;
    position: absolute;
    bottom: 10px;
    right: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* File upload progress */
.upload-progress {
    height: 6px;
    border-radius: 3px;
    background-color: #e5e7eb;
    margin-top: 15px;
    overflow: hidden;
    display: none;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    width: 0%;
    transition: width 0.3s ease;
}

/* Features list */
.features-list {
    margin: 20px 0;
    padding: 0;
    list-style: none;
}

.features-list li {
    position: relative;
    padding-left: 30px;
    margin-bottom: 12px;
    color: var(--text-color);
}

.features-list li:before {
    content: "✓";
    position: absolute;
    left: 0;
    top: 0;
    color: var(--secondary-color);
    font-weight: bold;
    font-size: 1.2rem;
}

/* Pro badge for premium features */
.pro-badge {
    background: linear-gradient(45deg, #f59e0b, #d97706);
    color: white;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.25em 0.6em;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-left: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* File info */
.file-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 15px;
    background-color: #f3f4f6;
    border-radius: 8px;
    margin-top: 15px;
}

.file-name {
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.file-name i, .file-name svg {
    color: var(--primary-color);
}

.file-size {
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
}

/* Glass morphism effect for premium elements */
.premium-card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
}

/* Settings icon button */
.settings-btn {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--primary-light);
    color: var(--primary-color);
    border: none;
    cursor: pointer;
    transition: var(--transition);
}

.settings-btn:hover {
    background-color: var(--primary-color);
    color: white;
}

/* Subtle scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #c5c9d5;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8aeb8;
}
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="spinner-overlay" id="loadingSpinner">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container">
        <header class="text-center mb-5">
            <h1 class="display-4 fw-bold">Social Media Image Resizer</h1>
            <p class="lead">Automatically resize your images for all social media platforms with custom focal points</p>
        </header>
        
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <?php if (!$uploaded): ?>
                <!-- Upload Form -->
                <div class="card fade-in">
                    <div class="card-header">
                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload Image
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" id="uploadForm">
                            <input type="hidden" name="process_type" value="upload">
                            <div class="upload-box" id="uploadBox">
                                <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                                <i class="fas fa-upload"></i>
                                <h5>Drag & Drop or Click to Upload</h5>
                                <p class="text-muted">Supported formats: JPG, PNG, GIF - Max size: 10MB</p>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-upload me-2"></i> Upload Image
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php else: ?>
                <!-- Image Editor -->
                <div class="card fade-in">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-crop-alt me-2"></i> Edit & Resize
                        </div>
                        <a href="?reset=1" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-upload me-1"></i> Upload New Image
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <i class="fas fa-image me-2"></i> Image Preview & Focal Point
                                    </div>
                                    <div class="card-body">
                                        <div id="imagePreviewContainer">
                                            <img src="<?php echo $originalImage; ?>" id="imagePreview" class="img-fluid">
                                            <div id="focalPoint"></div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <p class="mb-2"><i class="fas fa-bullseye me-1"></i> Drag the circle to set the focal point</p>
                                            <div class="small text-muted">
                                                Image: <?php echo $_SESSION['originalFileName']; ?> 
                                                (<?php echo $_SESSION['origWidth']; ?> × <?php echo $_SESSION['origHeight']; ?>px)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form method="post" id="resizeForm">
                                    <input type="hidden" name="process_type" value="resize">
                                    <input type="hidden" name="focalPointX" id="focalPointX" value="<?php echo $focalPointX; ?>">
                                    <input type="hidden" name="focalPointY" id="focalPointY" value="<?php echo $focalPointY; ?>">
                                    
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <i class="fas fa-sliders-h me-2"></i> Resize Options
                                        </div>
                                        <div class="card-body">
                                            <h5 class="mb-3">Select Social Media Platforms</h5>
                                            
                                            <?php foreach ($socialMediaSizes as $platform => $sizes): ?>
                                            <div class="platform-section">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="<?php echo $platform; ?>" name="<?php echo $platform; ?>" checked>
                                                    <label class="form-check-label platform-title" for="<?php echo $platform; ?>">
                                                        <i class="fab fa-<?php echo $platform; ?> platform-icon <?php echo $platform; ?>"></i>
                                                        <?php echo ucfirst($platform); ?> 
                                                        <span class="text-muted small">(<?php echo count($sizes); ?> sizes)</span>
                                                    </label>
                                                </div>
                                                <div class="small text-muted mt-2">
                                                    <?php 
                                                    $sizeDescriptions = [];
                                                    foreach ($sizes as $name => $dimensions) {
                                                        $sizeDescriptions[] = "$name ({$dimensions['width']}×{$dimensions['height']})";
                                                    }
                                                    echo implode(', ', $sizeDescriptions);
                                                    ?>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                            
                                            <div class="custom-size-container">
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" id="custom_resize" name="custom_resize">
                                                    <label class="form-check-label platform-title" for="custom_resize">
                                                        <i class="fas fa-crop-alt platform-icon"></i>
                                                        Custom Size
                                                    </label>
                                                </div>
                                                <div class="row" id="customSizeInputs" style="display: none;">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="customWidth" class="form-label">Width (px)</label>
                                                            <input type="number" class="form-control" id="customWidth" name="customWidth" value="<?php echo $customWidth; ?>" min="1">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="customHeight" class="form-label">Height (px)</label>
                                                            <input type="number" class="form-control" id="customHeight" name="customHeight" value="<?php echo $customHeight; ?>" min="1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                                    <i class="fas fa-magic me-2"></i> Generate All Sizes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <?php if (!empty($resizedImages)): ?>
                        <div class="mt-4 fade-in">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-images me-2"></i> Resized Images
                                </div>
                                <div class="card-body">
                                <div class="d-flex justify-content-end mb-3">
                                       <a href="<?php echo $_SESSION['zipFile']; ?>" class="btn btn-success">
                                           <i class="fas fa-download me-2"></i> Download All Images (ZIP)
                                       </a>
                                   </div>
                                   
                                   <ul class="nav nav-tabs mb-3" id="resultTabs" role="tablist">
                                       <?php
                                       $platforms = array_unique(array_column($resizedImages, 'platform'));
                                       foreach ($platforms as $index => $platform):
                                       ?>
                                       <li class="nav-item" role="presentation">
                                           <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" 
                                               id="<?php echo strtolower($platform); ?>-tab" 
                                               data-bs-toggle="tab" 
                                               data-bs-target="#<?php echo strtolower($platform); ?>" 
                                               type="button" 
                                               role="tab" 
                                               aria-controls="<?php echo strtolower($platform); ?>" 
                                               aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                               <?php if ($platform === 'Custom Size'): ?>
                                                   <i class="fas fa-crop-alt me-1"></i>
                                               <?php else: ?>
                                                   <i class="fab fa-<?php echo strtolower($platform); ?> me-1"></i>
                                               <?php endif; ?>
                                               <?php echo $platform; ?>
                                           </button>
                                       </li>
                                       <?php endforeach; ?>
                                   </ul>
                                   
                                   <div class="tab-content" id="resultTabsContent">
                                       <?php
                                       foreach ($platforms as $index => $platform):
                                       ?>
                                       <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" 
                                           id="<?php echo strtolower($platform); ?>" 
                                           role="tabpanel" 
                                           aria-labelledby="<?php echo strtolower($platform); ?>-tab">
                                           
                                           <div class="row">
                                               <?php
                                               $filteredImages = array_filter($resizedImages, function($image) use ($platform) {
                                                   return $image['platform'] === $platform;
                                               });
                                               
                                               foreach ($filteredImages as $image):
                                               ?>
                                               <div class="col-md-6 col-lg-4 mb-3">
                                                   <div class="resize-result">
                                                       <img src="resized/<?php echo $image['file']; ?>" class="resize-image" alt="<?php echo $image['name']; ?>">
                                                       <div class="d-flex justify-content-between align-items-center">
                                                           <div>
                                                               <h6 class="mb-0"><?php echo $image['name']; ?></h6>
                                                               <small class="text-muted"><?php echo $image['width']; ?> × <?php echo $image['height']; ?>px</small>
                                                           </div>
                                                           <a href="resized/<?php echo $image['file']; ?>" download class="btn btn-sm btn-outline-primary">
                                                               <i class="fas fa-download"></i>
                                                           </a>
                                                       </div>
                                                   </div>
                                               </div>
                                               <?php endforeach; ?>
                                           </div>
                                       </div>
                                       <?php endforeach; ?>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <?php endif; ?>
                   </div>
               </div>
               <?php endif; ?>
           </div>
       </div>
   </div>
   
   <footer class="mt-5">
       <div class="container">
           <div class="row">
               <div class="col-md-8">
                   <h2>About Social Media Image Resizer</h2>
                   <p>Our free online tool helps you resize your images for all major social media platforms with just a few clicks. Set a custom focal point to ensure your images look perfect on every platform.</p>
                   
                   <h3>Why Use Our Image Resizer?</h3>
                   <ul>
                       <li>Optimize images for Facebook, Instagram, Twitter, LinkedIn, Pinterest, YouTube, and TikTok</li>
                       <li>Set custom focal points to control what part of your image remains visible</li>
                       <li>Create custom sizes for your specific needs</li>
                       <li>Download individual images or get everything in a convenient ZIP file</li>
                       <li>Fast, free, and works on any device</li>
                   </ul>
               </div>
               <div class="col-md-4">
                   <h3>Supported Platforms</h3>
                   <ul class="list-unstyled">
                       <li><i class="fab fa-facebook platform-icon facebook"></i> Facebook</li>
                       <li><i class="fab fa-instagram platform-icon instagram"></i> Instagram</li>
                       <li><i class="fab fa-twitter platform-icon twitter"></i> Twitter/X</li>
                       <li><i class="fab fa-linkedin platform-icon linkedin"></i> LinkedIn</li>
                       <li><i class="fab fa-pinterest platform-icon pinterest"></i> Pinterest</li>
                       <li><i class="fab fa-youtube platform-icon youtube"></i> YouTube</li>
                       <li><i class="fab fa-tiktok platform-icon tiktok"></i> TikTok</li>
                   </ul>
               </div>
           </div>
           
           <hr class="my-4">
           
           <div class="row">
               <div class="col-md-8">
                   <h3>How to Use the Social Media Image Resizer</h3>
                   <ol>
                       <li><strong>Upload your image</strong> - Drag and drop or select an image from your device</li>
                       <li><strong>Set focal point</strong> - Drag the circle to the most important part of your image</li>
                       <li><strong>Choose platforms</strong> - Select which social media platforms you want to resize for</li>
                       <li><strong>Add custom sizes</strong> - Optionally add any specific dimensions you need</li>
                       <li><strong>Generate images</strong> - Click the button to create all your resized images</li>
                       <li><strong>Download</strong> - Get individual images or download all as a ZIP file</li>
                   </ol>
               </div>
               <div class="col-md-4">
                   <h3>Popular Image Sizes</h3>
                   <ul class="list-unstyled small">
                       <li><strong>Facebook Profile:</strong> 180 × 180px</li>
                       <li><strong>Facebook Cover:</strong> 820 × 312px</li>
                       <li><strong>Instagram Post:</strong> 1080 × 1080px</li>
                       <li><strong>Instagram Story:</strong> 1080 × 1920px</li>
                       <li><strong>Twitter Profile:</strong> 400 × 400px</li>
                       <li><strong>LinkedIn Cover:</strong> 1584 × 396px</li>
                       <li><strong>YouTube Thumbnail:</strong> 1280 × 720px</li>
                   </ul>
               </div>
           </div>
       </div>
   </footer>

   <!-- Bootstrap Bundle with Popper -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
   
   <script>
       document.addEventListener('DOMContentLoaded', function() {
           // File Upload handling
           const uploadBox = document.getElementById('uploadBox');
           const imageInput = document.getElementById('imageInput');
           
           if (uploadBox && imageInput) {
               uploadBox.addEventListener('click', function() {
                   imageInput.click();
               });
               
               imageInput.addEventListener('change', function() {
                   if (this.files && this.files[0]) {
                       document.getElementById('uploadForm').submit();
                       showLoading();
                   }
               });
               
               // Drag and drop handling
               uploadBox.addEventListener('dragover', function(e) {
                   e.preventDefault();
                   uploadBox.classList.add('border-primary');
               });
               
               uploadBox.addEventListener('dragleave', function() {
                   uploadBox.classList.remove('border-primary');
               });
               
               uploadBox.addEventListener('drop', function(e) {
                   e.preventDefault();
                   uploadBox.classList.remove('border-primary');
                   
                   if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                       imageInput.files = e.dataTransfer.files;
                       document.getElementById('uploadForm').submit();
                       showLoading();
                   }
               });
           }
           
           // Focal Point handling
           const imagePreview = document.getElementById('imagePreview');
           const focalPoint = document.getElementById('focalPoint');
           const focalPointXInput = document.getElementById('focalPointX');
           const focalPointYInput = document.getElementById('focalPointY');
           
           if (imagePreview && focalPoint && focalPointXInput && focalPointYInput) {
               // Initial position (center)
               let focalX = parseFloat(focalPointXInput.value) || 50;
               let focalY = parseFloat(focalPointYInput.value) || 50;
               
               // Update focal point position visually
               function updateFocalPointPosition() {
                   const rect = imagePreview.getBoundingClientRect();
                   const x = rect.width * (focalX / 100);
                   const y = rect.height * (focalY / 100);
                   
                   focalPoint.style.left = x + 'px';
                   focalPoint.style.top = y + 'px';
                   
                   // Update hidden inputs
                   focalPointXInput.value = focalX;
                   focalPointYInput.value = focalY;
               }
               
               // Initialize focal point position
               window.addEventListener('load', function() {
                   updateFocalPointPosition();
               });
               
               // Adjust focal point when window resizes
               window.addEventListener('resize', function() {
                   updateFocalPointPosition();
               });
               
               // Make focal point draggable
               let isDragging = false;
               
               focalPoint.addEventListener('mousedown', startDrag);
               focalPoint.addEventListener('touchstart', startDrag, { passive: false });
               
               function startDrag(e) {
                   e.preventDefault();
                   isDragging = true;
                   
                   document.addEventListener('mousemove', drag);
                   document.addEventListener('touchmove', drag, { passive: false });
                   document.addEventListener('mouseup', endDrag);
                   document.addEventListener('touchend', endDrag);
               }
               
               function drag(e) {
                   if (!isDragging) return;
                   
                   e.preventDefault();
                   
                   const rect = imagePreview.getBoundingClientRect();
                   let clientX, clientY;
                   
                   if (e.type === 'touchmove') {
                       clientX = e.touches[0].clientX;
                       clientY = e.touches[0].clientY;
                   } else {
                       clientX = e.clientX;
                       clientY = e.clientY;
                   }
                   
                   // Calculate position relative to image
                   let relativeX = clientX - rect.left;
                   let relativeY = clientY - rect.top;
                   
                   // Constrain to image boundaries
                   relativeX = Math.max(0, Math.min(rect.width, relativeX));
                   relativeY = Math.max(0, Math.min(rect.height, relativeY));
                   
                   // Convert to percentage
                   focalX = (relativeX / rect.width) * 100;
                   focalY = (relativeY / rect.height) * 100;
                   
                   // Update position
                   updateFocalPointPosition();
               }
               
               function endDrag() {
                   isDragging = false;
                   document.removeEventListener('mousemove', drag);
                   document.removeEventListener('touchmove', drag);
                   document.removeEventListener('mouseup', endDrag);
                   document.removeEventListener('touchend', endDrag);
               }
               
               // Also allow clicking on the image to set focal point
               imagePreview.addEventListener('click', function(e) {
                   const rect = imagePreview.getBoundingClientRect();
                   
                   // Calculate position relative to image
                   let relativeX = e.clientX - rect.left;
                   let relativeY = e.clientY - rect.top;
                   
                   // Convert to percentage
                   focalX = (relativeX / rect.width) * 100;
                   focalY = (relativeY / rect.height) * 100;
                   
                   // Update position
                   updateFocalPointPosition();
               });
           }
           
           // Custom size toggle
           const customResizeCheckbox = document.getElementById('custom_resize');
           const customSizeInputs = document.getElementById('customSizeInputs');
           
           if (customResizeCheckbox && customSizeInputs) {
               customResizeCheckbox.addEventListener('change', function() {
                   if (this.checked) {
                       customSizeInputs.style.display = 'flex';
                   } else {
                       customSizeInputs.style.display = 'none';
                   }
               });
           }
           
           // Show loading spinner on form submit
           const resizeForm = document.getElementById('resizeForm');
           if (resizeForm) {
               resizeForm.addEventListener('submit', function() {
                   showLoading();
               });
           }
           
           function showLoading() {
               const spinner = document.getElementById('loadingSpinner');
               if (spinner) {
                   spinner.classList.add('show');
               }
           }
       });
   </script>
</body>
</html>