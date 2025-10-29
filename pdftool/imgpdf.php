<?php
require_once('vendor/autoload.php');

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $uploadedImages = [];

    // Validate files
    if (empty($_FILES['images']['name'][0])) {
        $errors[] = 'Please select at least one image to upload.';
    } else {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['images']['name'][$key];
            $file_size = $_FILES['images']['size'][$key];
            $file_error = $_FILES['images']['error'][$key];
            
            // Check for upload errors
            if ($file_error !== UPLOAD_ERR_OK) {
                $errors[] = "Error uploading $file_name - " . getUploadError($file_error);
                continue;
            }
            
            // Validate image type
            $valid_mime = ['image/jpeg', 'image/png', 'image/gif'];
            $mime_type = mime_content_type($tmp_name);
            if (!in_array($mime_type, $valid_mime)) {
                $errors[] = "Invalid file type: $file_name (only JPG, PNG, GIF allowed)";
                continue;
            }
            
            // Validate image content
            if (!@getimagesize($tmp_name)) {
                $errors[] = "Invalid image file: $file_name";
                continue;
            }
            
            // Store mime type along with the temp path
            $uploadedImages[] = [
                'path' => $tmp_name,
                'type' => $mime_type
            ];
        }
    }

    // Create PDF if no errors
    if (empty($errors) && !empty($uploadedImages)) {
        try {
            $pdf = new FPDF();
            $pdf->SetAutoPageBreak(false);

            foreach ($uploadedImages as $image) {
                $imagePath = $image['path'];
                $imageType = $image['type'];
                
                // Convert mime type to FPDF format type
                $type = '';
                switch ($imageType) {
                    case 'image/jpeg':
                        $type = 'JPEG';
                        break;
                    case 'image/png':
                        $type = 'PNG';
                        break;
                    case 'image/gif':
                        $type = 'GIF';
                        break;
                }

                list($width, $height) = getimagesize($imagePath);

                // Calculate dimensions to fit A4
                $pageWidth = 210;  // A4 width in mm
                $pageHeight = 297; // A4 height in mm
                $ratio = $width / $height;

                $calcWidth = $pageWidth;
                $calcHeight = $calcWidth / $ratio;

                if ($calcHeight > $pageHeight) {
                    $calcHeight = $pageHeight;
                    $calcWidth = $calcHeight * $ratio;
                }

                // Center image on page
                $x = ($pageWidth - $calcWidth) / 2;
                $y = ($pageHeight - $calcHeight) / 2;

                // Add new page and image with explicit type
                $pdf->AddPage();
                $pdf->Image($imagePath, $x, $y, $calcWidth, $calcHeight, $type);
            }

            // Output PDF for download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="converted_images.pdf"');
            $pdf->Output('D', 'converted_images.pdf');
            exit;

        } catch (Exception $e) {
            $errors[] = 'Error generating PDF: ' . $e->getMessage();
        }
    }
}

function getUploadError($code) {
    $errors = [
        UPLOAD_ERR_INI_SIZE => 'File exceeds server size limit',
        UPLOAD_ERR_FORM_SIZE => 'File exceeds form size limit',
        UPLOAD_ERR_PARTIAL => 'File partially uploaded',
        UPLOAD_ERR_NO_FILE => 'No file uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write to disk',
        UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
    ];
    return $errors[$code] ?? 'Unknown upload error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Convert multiple images to a single PDF file instantly. Free online tool with premium quality output. Supports JPG, PNG, GIF formats.">
    <meta name="keywords" content="convert images to pdf, jpg to pdf, png to pdf, gif to pdf, merge images to pdf, free online pdf converter">
    <title>Image to PDF Converter - Free Online Tool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
        }
        body {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .upload-box {
            border: 3px dashed var(--primary);
            transition: all 0.3s ease;
            background: rgba(44, 62, 80, 0.05);
        }
        .upload-box:hover {
            border-color: var(--secondary);
            background: rgba(52, 152, 219, 0.05);
        }
        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 12px 30px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }
        .file-list {
            max-height: 200px;
            overflow-y: auto;
        }
        .drag-over {
            border-color: var(--secondary) !important;
            background: rgba(52, 152, 219, 0.1) !important;
        }
    </style>
</head>
<body class="d-flex flex-column">
    <div class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="text-center mb-4 display-4 fw-bold text-primary">Image to PDF Converter</h1>
                <div class="card shadow-lg">
                    <div class="card-body">
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error): ?>
                                    <div><?= htmlspecialchars($error) ?></div>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        
                        <form id="uploadForm" method="post" enctype="multipart/form-data">
                            <input type="file" name="images[]" id="fileInput" multiple accept="image/*" hidden>
                            
                            <div class="upload-box rounded-3 p-5 text-center mb-4" id="dropZone">
                                <i class="fas fa-file-upload fa-3x text-primary mb-3"></i>
                                <h3 class="mb-3">Drag & Drop Images Here</h3>
                                <p class="text-muted">or click to browse files</p>
                                <small class="text-muted">Supported formats: JPG, PNG, GIF</small>
                            </div>
                            
                            <div id="fileList" class="file-list mb-3"></div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-file-pdf me-2"></i> Convert to PDF
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- SEO Content -->
                <div class="mt-5 text-muted">
                    <h2 class="h4">Convert Images to PDF Online for Free</h2>
                    <p>
                        Easily convert multiple images to a single PDF file with our free online tool. 
                        Perfect for merging photos, creating portfolios, or archiving documents. 
                        Our image to PDF converter preserves image quality and works on any device. 
                        No registration required - simply upload your images and download your PDF instantly!
                    </p>
                    <p>
                        <strong>Features:</strong> Merge JPG to PDF, Combine PNG to PDF, 
                        High-quality output, Mobile-friendly interface, Secure processing 
                        (files deleted immediately after conversion)
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const dropZone = $('#dropZone');
            const fileInput = $('#fileInput');
            const fileList = $('#fileList');
            
            // Click handler
            dropZone.on('click', () => fileInput.click());
            
            // Drag & drop handlers
            dropZone.on('dragover', (e) => {
                e.preventDefault();
                dropZone.addClass('drag-over');
            });
            
            dropZone.on('dragleave', () => {
                dropZone.removeClass('drag-over');
            });
            
            dropZone.on('drop', (e) => {
                e.preventDefault();
                dropZone.removeClass('drag-over');
                const files = e.originalEvent.dataTransfer.files;
                handleFiles(files);
            });
            
            // File input change
            fileInput.on('change', (e) => {
                handleFiles(e.target.files);
            });
            
            // Handle file selection
            function handleFiles(files) {
                fileList.empty();
                for (const file of files) {
                    fileList.append(
                        `<div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                            <div>
                                <i class="fas fa-image me-2 text-primary"></i>
                                ${file.name}
                            </div>
                            <small class="text-muted">${(file.size/1024).toFixed(1)} KB</small>
                        </div>`
                    );
                }
            }
        });
    </script>
</body>
</html>