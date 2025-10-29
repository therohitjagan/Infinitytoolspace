<?php
require_once('vendor/autoload.php'); // Include Composer autoloader

use setasign\Fpdi\Fpdi;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_files'])) {
    $mergedPdf = new Fpdi();
    
    $files = $_FILES['pdf_files'];
    $validFiles = [];
    
    // Validate files
    foreach ($files['tmp_name'] as $key => $tmpName) {
        if ($files['error'][$key] === UPLOAD_ERR_OK) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($tmpName);
            if ($mime === 'application/pdf') {
                $validFiles[] = [
                    'tmp_name' => $tmpName,
                    'name' => $files['name'][$key]
                ];
            }
        }
    }

    if (count($validFiles) === 0) {
        $error = "Please upload valid PDF files.";
    } else {
        try {
            foreach ($validFiles as $file) {
                $pageCount = $mergedPdf->setSourceFile($file['tmp_name']);
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $template = $mergedPdf->importPage($pageNo);
                    $size = $mergedPdf->getTemplateSize($template);
                    $mergedPdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $mergedPdf->useTemplate($template);
                }
            }

            $outputFilename = 'merged-'.time().'.pdf';
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'.$outputFilename.'"');
            $mergedPdf->Output('D');
            exit;
        } catch (Exception $e) {
            $error = "Error merging PDFs: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Merge multiple PDF files into one with our free online PDF merger. Fast, secure, and easy to use. No registration or installation required.">
    <meta name="keywords" content="pdf merger, merge pdf files, combine pdfs online, free pdf joiner, merge pdf documents, join pdf pages, online pdf merger, combine pdf tool">
    <title>PDF Merger Pro - Combine PDF Files Online</title>
    <link rel="canonical" href="https://infinitytoolspace.com/pdftool/merge" />
    
    <meta property="og:title" content="PDF Merger - Merge PDF Files Online Free & Fast" />
<meta property="og:description" content="Easily combine multiple PDF files into one. Free online PDF merger with fast processing, no sign-up required." />
<meta property="og:url" content="https://infinitytoolspace.com/pdftool/merge" />
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


    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6c5ce7;
            --primary-light: #a29bfe;
            --primary-dark: #5849c2;
            --white: #ffffff;
            --light-bg: #f8f9fe;
            --dark-text: #2d3436;
            --gray-text: #636e72;
            --shadow: 0 10px 30px rgba(108, 92, 231, 0.15);
            --hover-shadow: 0 15px 40px rgba(108, 92, 231, 0.25);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7ff 0%, #f1f1fb 100%);
            color: var(--dark-text);
            min-height: 100vh;
            padding-bottom: 60px;
        }
        
        .navbar {
            background-color: var(--white);
            box-shadow: var(--shadow);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary);
        }
        
        .logo-text {
            margin-left: 10px;
        }
        
        .container {
            max-width: 900px;
        }
        
        .page-title {
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .page-subtitle {
            color: var(--gray-text);
            font-weight: 400;
            margin-bottom: 2rem;
        }
        
        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: var(--hover-shadow);
        }
        
        .card-header {
            background-color: var(--primary);
            color: var(--white);
            font-weight: 600;
            padding: 1.2rem 1.5rem;
            border: none;
        }
        
        .card-body {
            padding: 2rem;
            background: var(--white);
        }
        
        .upload-container {
            border: 2px dashed var(--primary-light);
            border-radius: 12px;
            padding: 2.5rem 1.5rem;
            text-align: center;
            background: var(--light-bg);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .upload-container:hover {
            border-color: var(--primary);
            background: rgba(162, 155, 254, 0.05);
        }
        
        .upload-icon {
            color: var(--primary);
            margin-bottom: 1rem;
            background: rgba(162, 155, 254, 0.2);
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
        }
        
        .upload-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-dark);
        }
        
        .drag-over {
            background: rgba(162, 155, 254, 0.1);
            border-color: var(--primary);
        }
        
        #file-list {
            max-height: 200px;
            overflow-y: auto;
            margin-top: 1.5rem;
        }
        
        .file-item {
            background: var(--white);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
            position: relative;
        }
        
        .file-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .file-item .file-icon {
            background: rgba(162, 155, 254, 0.1);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-right: 12px;
            color: var(--primary);
        }
        
        .file-item .file-name {
            font-weight: 500;
            flex-grow: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .file-item .file-size {
            color: var(--gray-text);
            font-size: 0.85rem;
            margin-left: auto;
            padding-left: 15px;
        }
        
        .file-item .file-remove {
            color: #ff6b6b;
            cursor: pointer;
            margin-left: 12px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        
        .file-item .file-remove:hover {
            opacity: 1;
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(to right, var(--primary-dark), var(--primary));
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.5);
            transform: translateY(-2px);
        }
        
        .btn-primary:disabled {
            background: #d1d1d1;
            box-shadow: none;
        }
        
        .features-row {
            padding: 3rem 0 2rem;
        }
        
        .feature-card {
            background: var(--white);
            border-radius: 16px;
            padding: 1.5rem;
            height: 100%;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(162, 155, 254, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.2rem;
            color: var(--primary);
        }
        
        .feature-title {
            font-weight: 600;
            margin-bottom: 0.8rem;
            color: var(--primary-dark);
        }
        
        .feature-text {
            color: var(--gray-text);
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .seo-content {
            background: var(--white);
            border-radius: 16px;
            padding: 2rem;
            margin-top: 3rem;
            box-shadow: var(--shadow);
        }
        
        .seo-title {
            color: var(--primary-dark);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .seo-text {
            color: var(--gray-text);
            font-size: 0.95rem;
            line-height: 1.7;
        }
        
        .footer {
            background: var(--primary-dark);
            color: var(--white);
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 0.9rem;
        }
        
        @media (max-width: 767px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .upload-container {
                padding: 1.5rem 1rem;
            }
            
            .features-row {
                padding: 2rem 0 1rem;
            }
            
            .feature-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div class="logo-icon me-2">
                    <i class="fas fa-file-pdf fa-lg text-primary"></i>
                </div>
                <span class="logo-text">PDF Merger Pro</span>
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="page-title text-center">PDF Merger Pro</h1>
        <p class="page-subtitle text-center">Combine multiple PDFs into one seamless document</p>
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-layer-group me-2"></i> Merge PDF Files
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger rounded-3">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <form id="uploadForm" method="post" enctype="multipart/form-data">
                    <div class="upload-container mb-4" id="dropZone">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt fa-2x"></i>
                        </div>
                        <h4 class="upload-title">Drag & Drop PDF Files</h4>
                        <p class="text-muted">or click to browse your files</p>
                        <input type="file" name="pdf_files[]" id="pdfFiles" class="d-none" multiple accept=".pdf">
                        
                        <div id="file-list" class="mt-4"></div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-5" id="mergeBtn" disabled>
                            <i class="fas fa-object-group me-2"></i> Merge PDFs
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row features-row">
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt fa-lg"></i>
                    </div>
                    <h5 class="feature-title">Secure Processing</h5>
                    <p class="feature-text">All your files are processed securely and deleted after merging. Your data never leaves your browser.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bolt fa-lg"></i>
                    </div>
                    <h5 class="feature-title">Lightning Fast</h5>
                    <p class="feature-text">Our optimized algorithms ensure quick processing no matter how many PDFs you need to combine.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-gem fa-lg"></i>
                    </div>
                    <h5 class="feature-title">Premium Quality</h5>
                    <p class="feature-text">Preserves the original quality of your PDFs while perfectly merging them into one document.</p>
                </div>
            </div>
        </div>

        <div class="seo-content">
            <h2 class="seo-title">Professional PDF Merging Made Simple</h2>
            <p class="seo-text">Combine multiple PDF documents into one unified file with our premium PDF merger tool. This professional-grade solution works directly in your browser - no software installation required! Preserve the original quality of your PDFs while merging, and rest assured that your files are secure with our SSL encryption.</p>
            
            <h3 class="seo-title h5 mt-4">How to Merge PDF Files:</h3>
            <ol class="seo-text">
                <li>Upload PDF files using the drag & drop area or file browser</li>
                <li>Rearrange files in your desired order (drag to reorder)</li>
                <li>Click "Merge PDFs" to combine all files</li>
                <li>Download your perfectly merged PDF document</li>
            </ol>

            <h3 class="seo-title h5 mt-4">Premium Features:</h3>
            <div class="row mt-3">
                <div class="col-md-6">
                    <ul class="seo-text">
                        <li>No file size limitations</li>
                        <li>Preserves all PDF elements and formatting</li>
                        <li>Secure SSL encryption</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="seo-text">
                        <li>No registration required</li>
                        <li>Works on any device and platform</li>
                        <li>Lightning-fast processing</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            &copy; 2025 PDF Merger Pro - All Rights Reserved
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            const dropZone = $('#dropZone');
            const fileInput = $('#pdfFiles');
            const fileList = $('#file-list');
            const mergeBtn = $('#mergeBtn');
            let files = [];

            // File input click handler
            dropZone.on('click', function(e) {
    // Stop the event if it's coming from the file input itself
    if ($(e.target).is(fileInput)) {
        return;
    }
    fileInput.click();
});

            // File input change handler
            fileInput.on('change', function() {
                const newFiles = Array.from(this.files);
                files = [...files, ...newFiles];
                updateFileList();
            });

            // Drag & drop handlers
            dropZone.on('dragover', function(e) {
                e.preventDefault();
                dropZone.addClass('drag-over');
            });

            dropZone.on('dragleave', function(e) {
                e.preventDefault();
                dropZone.removeClass('drag-over');
            });

            dropZone.on('drop', function(e) {
                e.preventDefault();
                dropZone.removeClass('drag-over');
                const newFiles = Array.from(e.originalEvent.dataTransfer.files);
                files = [...files, ...newFiles];
                updateFileList();
            });

            // Update file list display
            function updateFileList() {
                fileList.empty();
                
                if (files.length > 0) {
                    mergeBtn.prop('disabled', false);
                    
                    files.forEach((file, index) => {
                        fileList.append(`
                            <div class="file-item" data-index="${index}">
                                <div class="file-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${formatFileSize(file.size)}</div>
                                <div class="file-remove" data-index="${index}">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        `);
                    });
                    
                    // Make list items draggable for reordering
                    makeFileItemsDraggable();
                    
                    // Add remove file handler
                    $('.file-remove').on('click', function(e) {
                        e.stopPropagation();
                        const index = $(this).data('index');
                        files.splice(index, 1);
                        updateFileList();
                    });
                    
                } else {
                    mergeBtn.prop('disabled', true);
                    fileList.html('<p class="text-muted text-center mt-3 mb-0">No files selected</p>');
                }
                
                // Update the file input with the current files
                updateFileInput();
            }
            
            // Format file size
            function formatFileSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                else return (bytes / 1048576).toFixed(1) + ' MB';
            }
            
            // Make file items draggable for reordering
            function makeFileItemsDraggable() {
                let dragSrcEl = null;
                
                $('.file-item').on('dragstart', function(e) {
                    dragSrcEl = this;
                    e.originalEvent.dataTransfer.effectAllowed = 'move';
                    e.originalEvent.dataTransfer.setData('text/html', this.innerHTML);
                    $(this).addClass('dragging');
                });
                
                $('.file-item').on('dragover', function(e) {
                    e.preventDefault();
                    return false;
                });
                
                $('.file-item').on('dragenter', function(e) {
                    $(this).addClass('drag-over');
                });
                
                $('.file-item').on('dragleave', function(e) {
                    $(this).removeClass('drag-over');
                });
                
                $('.file-item').on('drop', function(e) {
                    e.preventDefault();
                    if (dragSrcEl !== this) {
                        // Get indices
                        const fromIndex = $(dragSrcEl).data('index');
                        const toIndex = $(this).data('index');
                        
                        // Reorder array
                        const item = files.splice(fromIndex, 1)[0];
                        files.splice(toIndex, 0, item);
                        
                        // Update UI
                        updateFileList();
                    }
                    return false;
                });
                
                $('.file-item').on('dragend', function(e) {
                    $('.file-item').removeClass('dragging drag-over');
                });
            }
            
            // Update the file input with current files
            function updateFileInput() {
                const dataTransfer = new DataTransfer();
                files.forEach(file => {
                    dataTransfer.items.add(file);
                });
                fileInput[0].files = dataTransfer.files;
            }

            // Form submission handler
            $('#uploadForm').on('submit', function() {
                mergeBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...').prop('disabled', true);
            });
        });
    </script>
    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "PDF Merger",
  "url": "https://infinitytoolspace.com/pdftool/merge",
  "description": "Merge multiple PDF documents into one seamlessly. Our free PDF merger tool is fast, secure, and requires no installation or login.",
  "applicationCategory": "Utility",
  "operatingSystem": "All",
  "browserRequirements": "Modern browser",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjxsUb20Vqj-FR5QaKP7Zkd_PoE58Il4hRrbZR2nWlcyrBHZ482QNAzD_ZiP60xvY1BzTYI-Q_cnrYhLVdx6lEVAntAMHwX71p-c82YFIJ4BKHDAu0DXVRMlDJV9isEKAbiDUqXnn-aL4CVnfj6C0fVLM-E_Q06VqLoXFixcyNaondnWNB1h89_3UOgL0B2/s2048/1000123029.jpg"
}
</script>

</body>
</html>