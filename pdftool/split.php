<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use setasign\Fpdi\Fpdi;

// Handle file download first
if (isset($_GET['download']) && isset($_SESSION['zipFile'])) {
    $zipFile = $_SESSION['zipFile'];
    if (file_exists($zipFile)) {
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="split_pdf.zip"');
        header('Content-Length: ' . filesize($zipFile));
        readfile($zipFile);
        unlink($zipFile);
        unset($_SESSION['zipFile']);
        exit;
    }
}

$output = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_FILES['pdfFile']) || $_FILES['pdfFile']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Please upload a valid PDF file');
        }

        $file = $_FILES['pdfFile']['tmp_name'];
        $filename = $_FILES['pdfFile']['name'];
        $mime = mime_content_type($file);
        
        if ($mime !== 'application/pdf') {
            throw new Exception('Only PDF files are allowed');
        }

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($file);
        
        if ($pageCount < 1) {
            throw new Exception('The PDF file appears to be empty');
        }

        $splitMethod = $_POST['splitMethod'] ?? 'range';
        $pages = [];
        
        if ($splitMethod === 'range') {
            $pageRanges = trim($_POST['pageRanges']);
            if (empty($pageRanges)) {
                throw new Exception('Please enter page ranges');
            }
            
            $ranges = explode(',', $pageRanges);
            foreach ($ranges as $range) {
                $range = explode('-', trim($range));
                $start = (int)$range[0];
                $end = isset($range[1]) ? (int)$range[1] : $start;
                
                if ($start < 1 || $end > $pageCount || $start > $end) {
                    throw new Exception('Invalid page range: ' . implode('-', $range));
                }
                
                for ($i = $start; $i <= $end; $i++) {
                    $pages[] = $i;
                }
            }
        } else {
            $splitEvery = (int)$_POST['splitEvery'];
            if ($splitEvery < 1) {
                throw new Exception('Invalid split value');
            }
            
            $parts = [];
            for ($i = 1; $i <= $pageCount; $i += $splitEvery) {
                $end = min($i + $splitEvery - 1, $pageCount);
                $parts[] = range($i, $end);
            }
            $pages = $parts;
        }

        $zip = new ZipArchive();
        $zipFilename = tempnam(sys_get_temp_dir(), 'split_pdf_') . '.zip';
        
        if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            throw new Exception('Cannot create ZIP file');
        }

        $tempFiles = [];

        if ($splitMethod === 'range') {
            // Individual pages
            foreach ($pages as $pageNumber) {
                $newPdf = new Fpdi();
                $newPdf->AddPage();
                $newPdf->setSourceFile($file);
                $newPdf->useTemplate($newPdf->importPage($pageNumber));
                
                $tempPdf = tempnam(sys_get_temp_dir(), 'pdf_');
                $tempFiles[] = $tempPdf;
                $newPdf->Output($tempPdf, 'F');
                
                $partName = sprintf('Page-%d.pdf', $pageNumber);
                $zip->addFile($tempPdf, $partName);
            }
        } else {
            // Split into parts
            foreach ($pages as $index => $pageRange) {
                $newPdf = new Fpdi();
                
                foreach ($pageRange as $pageNumber) {
                    $template = $pdf->setSourceFile($file); // Reset for each import
                    $pageTemplate = $pdf->importPage($pageNumber);
                    
                    $newPdf->AddPage();
                    $newPdf->setSourceFile($file);
                    $newPdf->useTemplate($newPdf->importPage($pageNumber));
                }
                
                $tempPdf = tempnam(sys_get_temp_dir(), 'pdf_');
                $tempFiles[] = $tempPdf;
                $newPdf->Output($tempPdf, 'F');
                
                $partName = sprintf('Part-%d.pdf', $index + 1);
                $zip->addFile($tempPdf, $partName);
            }
        }

        $zip->close();
        
        // Clean up temp files
        foreach ($tempFiles as $tempFile) {
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
        
        $_SESSION['zipFile'] = $zipFilename;
        $output = $zipFilename;
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
    <title>Free PDF Splitter - Split PDF Documents Online</title>
    <meta name="description" content="Split PDF files quickly and easily. Split by page ranges or split into multiple documents. Free online PDF splitter tool.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(45deg, #6c5ce7, #a66efa);
            color: white;
            padding: 4rem 0;
            margin-bottom: 2rem;
        }
        .upload-box {
            border: 2px dashed #6c5ce7;
            padding: 2rem;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            transition: all 0.3s;
        }
        .upload-box:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #6c5ce7;
            margin-bottom: 1rem;
        }
        .seo-content {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 15px;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <h1 class="text-center mb-4"><i class="fas fa-file-pdf"></i> PDF Splitter</h1>
            <div class="upload-box">
                <form id="splitForm" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="file" class="form-control" name="pdfFile" id="pdfFile" accept=".pdf" required>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="splitMethod" id="rangeMethod" value="range" checked>
                            <label class="form-check-label" for="rangeMethod">Page Ranges</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="splitMethod" id="splitEveryMethod" value="splitEvery">
                            <label class="form-check-label" for="splitEveryMethod">Split Every</label>
                        </div>
                    </div>

                    <div id="rangeSection" class="mb-3">
                        <input type="text" class="form-control" name="pageRanges" placeholder="Example: 1-3,5,7-9">
                        <small class="form-text text-light">Enter page ranges separated by commas (e.g., 1-3,5,7-9)</small>
                    </div>

                    <div id="splitEverySection" class="mb-3" style="display: none;">
                        <div class="input-group">
                            <input type="number" class="form-control" name="splitEvery" min="1" value="1" placeholder="Pages per document">
                            <span class="input-group-text">pages</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-light btn-lg mt-3">
                        <i class="fas fa-split"></i> Split PDF
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php elseif (isset($_SESSION['zipFile'])): ?>
            <div class="text-center mt-4">
                <div class="alert alert-success">
                    <h4>PDF successfully split!</h4>
                    <p>Your PDF has been successfully processed and is ready for download.</p>
                </div>
                <a href="?download=1" class="btn btn-success btn-lg">
                    <i class="fas fa-download"></i> Download Split Files
                </a>
            </div>
        <?php endif; ?>

        <div class="row mt-5">
            <div class="col-md-4 text-center mb-4">
                <i class="fas fa-shield-alt feature-icon"></i>
                <h3>Secure Processing</h3>
                <p>Your files are processed securely and deleted automatically after processing.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <i class="fas fa-mobile-alt feature-icon"></i>
                <h3>Mobile Friendly</h3>
                <p>Works perfectly on all devices - smartphones, tablets, and computers.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <i class="fas fa-cloud feature-icon"></i>
                <h3>Cloud Based</h3>
                <p>No software installation required. Split PDFs directly in your browser.</p>
            </div>
        </div>

        <div class="seo-content">
            <h2>Free Online PDF Splitter Tool</h2>
            <p>Split PDF documents quickly and easily with our free online PDF splitter. This tool allows you to split PDF files by individual pages or page ranges. Perfect for organizing large documents, extracting specific pages, or preparing files for sharing. Our PDF splitter maintains the original quality of your documents and works on any device without requiring software installation.</p>
            <h3>How to Split PDF Files:</h3>
            <ol>
                <li>Upload your PDF file using the button above</li>
                <li>Choose your splitting method (page ranges or split interval)</li>
                <li>Click the Split PDF button</li>
                <li>Download your separated PDF files in ZIP format</li>
            </ol>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[name="splitMethod"]').change(function() {
                if ($(this).val() === 'range') {
                    $('#rangeSection').show();
                    $('#splitEverySection').hide();
                } else {
                    $('#rangeSection').hide();
                    $('#splitEverySection').show();
                }
            });

            $('#splitForm').submit(function(e) {
                const fileInput = $('#pdfFile')[0];
                if (fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Please select a PDF file');
                    return false;
                }
                
                if ($('#rangeMethod').is(':checked')) {
                    const rangeValue = $('input[name="pageRanges"]').val().trim();
                    if (!rangeValue) {
                        e.preventDefault();
                        alert('Please enter page ranges');
                        return false;
                    }
                } else {
                    const splitValue = parseInt($('input[name="splitEvery"]').val());
                    if (!splitValue || splitValue < 1) {
                        e.preventDefault();
                        alert('Please enter a valid number of pages');
                        return false;
                    }
                }
            });
        });
    </script>
</body>
</html>