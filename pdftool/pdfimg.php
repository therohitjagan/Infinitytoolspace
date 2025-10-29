<?php
// Check required extensions
if (!extension_loaded('imagick')) {
    die('<div class="alert alert-danger">Imagick extension is not installed. Please contact your hosting provider.</div>');
}
if (!class_exists('ZipArchive')) {
    die('<div class="alert alert-danger">ZIP extension is not enabled. Please enable ZipArchive PHP extension.</div>');
}

// Configuration
$max_file_size = 25 * 1024 * 1024; // 25MB
$allowed_types = ['application/pdf', 'application/x-pdf'];
$upload_dir = 'uploads/';
$output_dir = 'converted/';

// Ensure directories exist
if (!file_exists($upload_dir)) mkdir($upload_dir, 0755, true);
if (!file_exists($output_dir)) mkdir($output_dir, 0755, true);

$error = $success = '';
$download_link = '';
$images_dir_url = '';
$pages = [];
$page_count = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate upload
        if (empty($_FILES['pdf_file']['name'])) throw new Exception('Please select a PDF file');
        if ($_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) throw new Exception('File upload error');
        if ($_FILES['pdf_file']['size'] > $max_file_size) throw new Exception('File size exceeds 25MB limit');

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['pdf_file']['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime_type, $allowed_types)) throw new Exception('Invalid file type');

        // Unique job ID
        $job_id = uniqid('job_');
        $filename = $job_id . '.pdf';
        $upload_path = $upload_dir . $filename;
        $output_path = $output_dir . $job_id . '/';
        mkdir($output_path, 0755, true);

        // Move uploaded file
        if (!move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_path)) {
            throw new Exception("Failed to move uploaded file.");
        }

        // Convert PDF to images
        $imagick = new Imagick();
        $imagick->setResolution(150, 150);
        $imagick->readImage($upload_path);
        $imagick->setImageFormat('jpg');
        $imagick->setImageCompressionQuality(85);

        foreach ($imagick as $index => $page) {
            $page_name = "page_" . ($index + 1) . ".jpg";
            $page_path = $output_path . $page_name;
            $page->writeImage($page_path);
            $pages[] = $page_name;
        }

        // Create ZIP
        $zip_filename = $job_id . '.zip';
        $zip_path = $output_dir . $zip_filename;
        $zip = new ZipArchive();
        if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            throw new Exception("Failed to create ZIP archive");
        }
        foreach ($pages as $page) {
            $zip->addFile($output_path . $page, $page);
        }
        $zip->close();

        $success = 'File converted successfully!';
        $download_link = $zip_path;
        $images_dir_url = $output_path;
        $page_count = count($pages);

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
    <title>PDF to Images Converter - Free Online Tool</title>
    <meta name="description" content="Convert PDF documents to high-quality JPG images online for free. Full page conversion with premium quality output. No registration required.">
    <meta name="keywords" content="pdf to images, convert pdf to jpg, pdf to jpg converter, online pdf converter">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .main-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        .upload-box {
            border: 2px dashed #0d6efd;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: rgba(13, 110, 253, 0.05);
        }
        .upload-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .premium-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #ffc107;
            color: #000;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }
        .result-image {
            transition: transform 0.3s ease;
            border: 1px solid #dee2e6;
            border-radius: 10px;
        }
        .result-image:hover {
            transform: scale(1.03);
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="container py-5">
            <h1 class="text-center mb-4 display-4 fw-bold text-primary">
                PDF to Images Converter
                <span class="premium-badge">PREMIUM</span>
            </h1>
            
            <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
    <div class="alert alert-success">
        <?= $success ?> Converted <?= $page_count ?> pages.
        <div class="mt-2">
            <a href="<?= htmlspecialchars($download_link) ?>" class="btn btn-success" download>
                <i class="fas fa-download me-2"></i>Download All Images (ZIP)
            </a>
        </div>
    </div>

    <div class="row g-3">
        <?php foreach ($pages as $page): ?>
        <div class="col-md-4 col-lg-3">
            <div class="card result-image">
                <img src="<?= htmlspecialchars($images_dir_url . $page) ?>" class="card-img-top" alt="Page <?= $page ?>">
                <div class="card-footer text-center">
                    <a href="<?= htmlspecialchars($images_dir_url . $page) ?>" download class="btn btn-sm btn-primary">
                        <i class="fas fa-download me-1"></i>Download
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>

            
            <div class="upload-box p-5 text-center my-4 position-relative">
                <form id="convertForm" method="POST" enctype="multipart/form-data">
                    <input type="file" name="pdf_file" id="pdfInput" accept="application/pdf" hidden>
                    <label for="pdfInput" class="w-100 cursor-pointer">
                        <div class="mb-3">
                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                        </div>
                        <h4 class="mb-3">Drag & Drop PDF File</h4>
                        <p class="text-muted">or click to select file</p>
                        <div class="mt-3">
                            <button type="button" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-upload me-2"></i>Choose PDF File
                            </button>
                        </div>
                        <div class="mt-2 text-muted small">
                            Max file size: 25MB • PDF Only
                        </div>
                    </label>
                </form>
            </div>
            <?php endif; ?>
        </div>

        <!-- SEO Content -->
        <footer class="bg-dark text-white py-4 mt-5">
            <div class="container">
                <h3 class="h5">PDF to Images Converter - Free Online Tool</h3>
                <p class="small">Convert your PDF documents to high-quality JPG images instantly with our free online converter. Our tool supports multi-page PDF conversion, maintains original quality, and provides quick downloads. Perfect for converting reports, presentations, and documents to image format for easy sharing and editing.</p>
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="h6">Features:</h4>
                        <ul class="small">
                            <li>High-quality PDF to JPG conversion</li>
                            <li>Multi-page support</li>
                            <li>Secure file handling</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4 class="h6">Why Choose Us?</h4>
                        <ul class="small">
                            <li>No registration required</li>
                            <li>Full privacy protection</li>
                            <li>Mobile-friendly interface</li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // File upload trigger
        $('.upload-box button').click(function() {
            $('#pdfInput').click();
        });

        // Drag & drop functionality
        const uploadBox = $('.upload-box');
        $('#pdfInput').on('change', function() {
            if(this.files.length > 0) {
                $('#convertForm').submit();
            }
        });

        uploadBox.on('dragover', function(e) {
            e.preventDefault();
            uploadBox.addClass('bg-primary text-white').css('border-style', 'solid');
        });

        uploadBox.on('dragleave', function(e) {
            e.preventDefault();
            uploadBox.removeClass('bg-primary text-white').css('border-style', 'dashed');
        });

        uploadBox.on('drop', function(e) {
            e.preventDefault();
            uploadBox.removeClass('bg-primary text-white').css('border-style', 'dashed');
            const files = e.originalEvent.dataTransfer.files;
            if(files.length > 0 && files[0].type === 'application/pdf') {
                $('#pdfInput').prop('files', files);
                $('#convertForm').submit();
            }
        });
    });
    </script>
</body>
</html>