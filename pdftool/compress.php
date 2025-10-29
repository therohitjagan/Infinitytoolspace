<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'vendor/autoload.php'; // Ensure mPDF is installed via Composer

// Handle PDF compression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
    try {
        $uploadDir = 'temp/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
        
        // Validate file
        $file = $_FILES['pdfFile'];
        if ($file['error'] !== UPLOAD_ERR_OK) throw new Exception('File upload error');
        if ($file['type'] !== 'application/pdf') throw new Exception('Invalid file type');
        
        // Process compression
        $compressionLevel = $_POST['compressionLevel'] ?? 'medium';
        $tempFile = $uploadDir . uniqid() . '.pdf';
        move_uploaded_file($file['tmp_name'], $tempFile);
        
        // Configure mPDF compression settings
        $config = [
            'low' => ['compress' => true, 'dpi' => 150],
            'medium' => ['compress' => true, 'dpi' => 96],
            'high' => ['compress' => true, 'dpi' => 72]
        ][$compressionLevel];
        
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'c',
            'format' => 'A4',
            'default_font_size' => 12,
            'default_font' => 'dejavusans',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
            'margin_header' => 9,
            'margin_footer' => 9,
            'tempDir' => $uploadDir,
            'compress' => $config['compress'],
            'dpi' => $config['dpi']
        ]);
        
        $pageCount = $mpdf->SetSourceFile($tempFile);
        for ($i = 1; $i <= $pageCount; $i++) {
            $page = $mpdf->ImportPage($i);
            $mpdf->AddPage();
            $mpdf->UseTemplate($page);
        }
        
        // Output compressed PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="compressed.pdf"');
        $mpdf->Output();
        
        // Cleanup
        unlink($tempFile);
        exit;
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
    <title>PDF Compressor - Reduce PDF File Size Online</title>
    <meta name="description" content="Compress PDF files online without losing quality. Reduce PDF size instantly and for free. Fast, secure, and works on all devices—no registration needed.">
    <meta name="keywords" content="compress PDF, reduce PDF size, PDF compressor, online PDF tool, optimize PDF, pdf compressor, compress pdf online, reduce pdf size, shrink pdf, free pdf compression, optimize pdf, online pdf tool, small pdf file">
    
    <link rel="canonical" href="https://infinitytoolspace.com/pdftool/compress" />
    
    <meta property="og:title" content="PDF Compressor - Compress PDF Files Online Free" />
<meta property="og:description" content="Easily compress PDF files without quality loss. Free, fast, and secure tool to reduce PDF file size online." />
<meta property="og:url" content="https://infinitytoolspace.com/pdftool/compress" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjxsUb20Vqj-FR5QaKP7Zkd_PoE58Il4hRrbZR2nWlcyrBHZ482QNAzD_ZiP60xvY1BzTYI-Q_cnrYhLVdx6lEVAntAMHwX71p-c82YFIJ4BKHDAu0DXVRMlDJV9isEKAbiDUqXnn-aL4CVnfj6C0fVLM-E_Q06VqLoXFixcyNaondnWNB1h89_3UOgL0B2/s2048/1000123029.jpg" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>


    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .upload-box {
            border: 2px dashed #0d6efd;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: rgba(13, 110, 253, 0.05);
        }
        .upload-box:hover {
            background: rgba(13, 110, 253, 0.1);
            transform: translateY(-2px);
        }
        .premium-feeling {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="premium-feeling bg-white p-4 p-md-5 mb-4">
                    <h1 class="text-center mb-4">PDF Compressor</h1>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <div class="upload-box p-5 text-center mb-4">
                            <input type="file" name="pdfFile" id="pdfFile" class="d-none" accept="application/pdf" required>
                            <label for="pdfFile" class="cursor-pointer">
                                <i class="fas fa-file-pdf fa-3x text-primary mb-3"></i>
                                <h5>Choose PDF File</h5>
                                <p class="text-muted mb-0">Max file size: 25MB</p>
                            </label>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Compression Level</label>
                            <select name="compressionLevel" class="form-select">
                                <option value="low">Low Compression (Best Quality)</option>
                                <option value="medium" selected>Medium Compression</option>
                                <option value="high">High Compression (Smaller File Size)</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-compress me-2"></i> Compress PDF
                        </button>
                    </form>
                </div>

                <!-- SEO Content -->
                <div class="mt-5 text-muted">
                    <h2 class="h4">Free Online PDF Compressor</h2>
                    <p>Our powerful PDF compression tool helps you reduce PDF file sizes while maintaining good visual quality. This online PDF compressor is completely free to use and works on any device. Compress PDF documents quickly and securely without any watermarks or quality loss.</p>
                    
                    <h3 class="h5 mt-4">How to Compress PDF Files:</h3>
                    <ol>
                        <li>Select your PDF file using the upload button</li>
                        <li>Choose desired compression level</li>
                        <li>Click "Compress PDF" button</li>
                        <li>Download your compressed PDF file</li>
                    </ol>
                    
                    <p class="mt-4"><strong>Features:</strong> PDF compression, PDF optimization, reduce PDF size, online PDF tool, free PDF compressor, compress PDF without quality loss</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show file name when selected
        document.getElementById('pdfFile').addEventListener('change', function(e) {
            const label = this.nextElementSibling;
            const fileName = this.files[0]?.name || 'Choose PDF File';
            label.querySelector('h5').textContent = fileName;
        });
    </script>
    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "PDF Compressor",
  "url": "https://infinitytoolspace.com/pdftool/compress",
  "description": "Compress PDF files online for free without losing quality. Quickly reduce PDF file size and optimize documents for sharing and storage.",
  "applicationCategory": "Utility",
  "operatingSystem": "All",
  "browserRequirements": "Modern browser",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjxsUb20Vqj-FR5QaKP7Zkd_PoE58Il4hRrbZR2nWlcyrBHZ482QNAzD_ZiP60xvY1BzTYI-Q_cnrYhLVdx6lEVAntAMHwX71p-c82YFIJ4BKHDAu0DXVRMlDJV9isEKAbiDUqXnn-aL4CVnfj6C0fVLM-E_Q06VqLoXFixcyNaondnWNB1h89_3UOgL0B2/s2048/1000123029.jpg"
}
</script>

</body>
</html>
