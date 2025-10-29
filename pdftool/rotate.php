<?php
// require_once('fpdf/fpdf.php');
// require_once('fpdi/src/autoload.php');

require_once('vendor/autoload.php');

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = uniqid() . '.pdf';
    $uploadPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $uploadPath)) {
        try {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($uploadPath);
            
            $rotations = $_POST['rotation'] ?? [];
            
            for ($i = 1; $i <= $pageCount; $i++) {
                $rotation = isset($rotations[$i-1]) ? (int)$rotations[$i-1] : 0;
                
                // Import page with rotation
                $templateId = $pdf->importPage($i, PdfReader\PageBoundaries::MEDIA_BOX, true, $rotation);
                $size = $pdf->getTemplateSize($templateId);
                
                // Add page with correct orientation
                $pdf->AddPage(
                    $size['width'] > $size['height'] ? 'L' : 'P',
                    [$size['width'], $size['height']]
                );
                
                // Use template without additional rotation
                $pdf->useTemplate($templateId);
            }

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="rotated.pdf"');
            echo $pdf->Output('S');
            unlink($uploadPath);
            exit;
        } catch (Exception $e) {
            $error = "Error processing PDF: " . $e->getMessage();
        }
    } else {
        $error = "File upload failed";
    }
}
?>

<!-- Keep the rest of the HTML/CSS/JS unchanged from previous version -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Rotator - Rotate PDF Pages Online</title>
    <meta name="description" content="Free online PDF rotator tool. Rotate PDF pages 90°, 180°, or 270°. Preserve quality, secure processing, and works on all devices.">
    <meta name="keywords" content="rotate PDF, PDF rotator, rotate PDF pages, online PDF tool, PDF editor">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #4a90e2;
            --hover-color: #357abd;
        }
        
        body {
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        .main-card {
            max-width: 800px;
            margin: 2rem auto;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .drop-zone {
            border: 2px dashed #ced4da;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .drop-zone:hover {
            border-color: var(--primary-color);
            background: rgba(74, 144, 226, 0.05);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--hover-color);
        }
        
        .rotation-control {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card main-card">
            <div class="card-body">
                <h1 class="text-center mb-4"><i class="fas fa-file-pdf text-danger"></i> PDF Rotator</h1>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <form id="pdfForm" method="post" enctype="multipart/form-data">
                    <div class="drop-zone" onclick="document.getElementById('pdfInput').click()">
                        <i class="fas fa-file-upload fa-3x text-muted mb-3"></i>
                        <h4>Drag & Drop PDF or Click to Upload</h4>
                        <p class="text-muted">Max file size: 25MB</p>
                        <input type="file" name="pdfFile" id="pdfInput" accept="application/pdf" hidden required>
                    </div>
                    
                    <div id="rotationControls" class="mt-4"></div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync me-2"></i> Rotate PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- SEO Section -->
        <div class="mt-5 text-muted" style="font-size: 0.9rem;">
            <h2 class="h5">PDF Rotator - Free Online Tool</h2>
            <p>RotatePDF.pro is a free online PDF rotation tool that allows you to rotate PDF pages 90 degrees clockwise, 180 degrees, or 270 degrees counter-clockwise. Our tool works on any device including mobile phones and tablets. All files are processed securely and deleted immediately after conversion.</p>
            <p><strong>Features:</strong> Rotate PDF Pages • Preserve Original Quality • 256-bit SSL Encryption • No Installation Required • Mobile-Friendly Interface</p>
        </div>
    </div>

    <script>
        // Dynamic Rotation Controls
        document.getElementById('pdfInput').addEventListener('change', function(e) {
            const controls = document.getElementById('rotationControls');
            controls.innerHTML = '';
            
            const files = e.target.files;
            if (files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create 3 rotation controls by default (user can add more)
                    addRotationControl();
                    addRotationControl();
                    addRotationControl();
                };
                reader.readAsArrayBuffer(files[0]);
            }
        });

        function addRotationControl() {
            const div = document.createElement('div');
            div.className = 'rotation-control';
            div.innerHTML = `
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label">Page ${document.querySelectorAll('.rotation-control').length + 1}</label>
                    </div>
                    <div class="col">
                        <select name="rotation[]" class="form-select">
                            <option value="0">No Rotation</option>
                            <option value="90">90° Clockwise</option>
                            <option value="180">180°</option>
                            <option value="270">270° Clockwise</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            document.getElementById('rotationControls').appendChild(div);
        }

        // Drag & Drop Handling
        const dropZone = document.querySelector('.drop-zone');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
            dropZone.addEventListener(event, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(event => {
            dropZone.addEventListener(event, highlight, false);
        });

        ['dragleave', 'drop'].forEach(event => {
            dropZone.addEventListener(event, unhighlight, false);
        });

        function highlight(e) {
            dropZone.style.borderColor = '#4a90e2';
        }

        function unhighlight(e) {
            dropZone.style.borderColor = '#ced4da';
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('pdfInput').files = files;
            this.dispatchEvent(new Event('change'));
        }
    </script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>