<?php
session_start();
$notes_dir = 'notes/';
if (!file_exists($notes_dir)) mkdir($notes_dir, 0755, true);

// File operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $response = ['success' => false];
        
        if ($_POST['action'] === 'save' && isset($_POST['filename']) && isset($_POST['content'])) {
            $filename = preg_replace('/[^a-zA-Z0-9\-_\.]/', '', $_POST['filename']);
            if (!str_ends_with($filename, '.txt')) $filename .= '.txt';
            file_put_contents($notes_dir . $filename, $_POST['content']);
            $_SESSION['current_file'] = $filename;
            $response = ['success' => true, 'filename' => $filename];
        } elseif ($_POST['action'] === 'delete' && isset($_POST['filename'])) {
            $filename = $_POST['filename'];
            if (file_exists($notes_dir . $filename)) {
                unlink($notes_dir . $filename);
                $response = ['success' => true];
            }
        }
        
        echo json_encode($response);
        exit;
    }
}

$files = glob($notes_dir . '*.txt');
$current_content = '';
$current_file = '';
// Add to your PHP at the top after initializing $current_content and $current_file:
$current_tags = '';
if (isset($_GET['file']) && file_exists($notes_dir . $_GET['file'])) {
    // Get tags from file metadata or first line
    $lines = explode("\n", $current_content, 2);
    if (count($lines) > 0 && strpos($lines[0], 'Tags:') === 0) {
        $current_tags = substr($lines[0], 5);
        $current_content = count($lines) > 1 ? $lines[1] : '';
    }
}
if (isset($_GET['file']) && file_exists($notes_dir . $_GET['file'])) {
    $current_content = file_get_contents($notes_dir . $_GET['file']);
    $current_file = $_GET['file'];
    $_SESSION['current_file'] = $current_file;
} elseif (isset($_SESSION['current_file']) && file_exists($notes_dir . $_SESSION['current_file'])) {
    $current_content = file_get_contents($notes_dir . $_SESSION['current_file']);
    $current_file = $_SESSION['current_file'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Notepad - Write & Save Notes Instantly</title>
    <meta name="description" content="Free online notepad to write, save, and edit text instantly. No login or signup needed. Perfect for quick notes, drafts, and brainstorming ideas.">
    <meta name="keywords" content="online notepad, free notepad, write notes online, save notes, simple notepad, web notepad, notepad without login, text editor online, browser notepad">
    <link rel="canonical" href="https://infinitytoolspace.com/tools/notepad" />
    
    <meta property="og:title" content="Online Notepad - Write & Save Notes Instantly" />
<meta property="og:description" content="Use our free online notepad to write, save, and edit text in your browser. No login required. Quick, easy, and secure!" />
<meta property="og:url" content="https://infinitytoolspace.com/tools/notepad" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjCP_jgM4f3f-1cA7IL2B6zFzqOtw_H4-qHsy3NMfhvQG-Lu-3IXwWMaBjSFyRYBB0KBBg7HTAs9Gb6CO5Tn0Xtb1WWblHwskz57A1SkGXDTWFRB12iMwCmAQ6qH40y68ELpEwFlzucu9WXCAH4v5uCRjvOLx_t7AzU13woMQBH1OsjmD-chV_yb-6JXI8/s16000/Heading%20(5).png" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #5568FE;
            --primary-hover: #4254fc;
            --secondary: #6c757d;
            --accent: #7747FF;
            --accent-hover: #6633ff;
            --success: #2DD4BF;
            --danger: #EF4444;
            --warning: #F59E0B;
            --info: #3B82F6;
            --light: #f8f9fa;
            --dark: #111827;
            --background: #ffffff;
            --text: #1F2937;
            --border: #e5e7eb;
            --shadow: rgba(0, 0, 0, 0.05);
        }

        /* Dark Mode Colors */
        .dark-mode {
            --primary: #6366F1;
            --primary-hover: #4F46E5;
            --secondary: #9CA3AF;
            --accent: #8B5CF6;
            --accent-hover: #7C3AED;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --info: #3B82F6;
            --light: #4B5563;
            --dark: #E5E7EB;
            --background: #1F2937;
            --text: #F9FAFB;
            --border: #374151;
            --shadow: rgba(0, 0, 0, 0.3);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text);
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar {
            background: var(--background);
            box-shadow: 0 1px 3px var(--shadow);
            border-bottom: 1px solid var(--border);
            padding: 0.75rem 0;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: var(--primary);
            font-size: 1.25rem;
        }
        
        .navbar-brand i {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .editor-container {
            flex: 1;
            border-radius: 12px;
            box-shadow: 0 4px 12px var(--shadow);
            background: var(--background);
            overflow: hidden;
            transition: all 0.3s ease;
            height: calc(100vh - 180px);
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border);
        }
        
        #editor {
            flex: 1;
            width: 100%;
            border: none;
            padding: 1.25rem;
            font-family: 'Fira Code', monospace;
            font-size: 16px;
            line-height: 1.6;
            resize: none;
            background: var(--background);
            color: var(--text);
        }
        
        #editor:focus { 
            outline: none; 
        }
        
        .preview-container {
            position: fixed;
            top: 0;
            right: 0;
            width: 50%;
            height: 100vh;
            background: var(--background);
            z-index: 1000;
            box-shadow: -5px 0 15px var(--shadow);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
            padding: 1rem;
            border-left: 1px solid var(--border);
        }
        
        .preview-container.active {
            transform: translateX(0);
        }
        
        #preview {
            padding: 1.25rem;
        }
        
        .toolbar {
            background: var(--background);
            border-radius: 8px;
            padding: 0.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px var(--shadow);
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            border: 1px solid var(--border);
        }
        
        .toolbar-group {
            display: flex;
            gap: 5px;
            padding: 0 5px;
            border-right: 1px solid var(--border);
        }
        
        .toolbar-group:last-child {
            border-right: none;
        }
        
        .btn {
            border-radius: 6px;
            transition: all 0.2s;
            padding: 0.4rem 0.75rem;
        }
        
        .btn-icon {
            padding: 0.4rem 0.5rem;
            font-size: 0.9rem;
        }
        
        .btn-primary { 
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover { 
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        
        .btn-accent {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }
        
        .btn-accent:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
            color: white;
        }
        
        .btn-light {
            background: var(--light);
            border-color: var(--border);
            color: var(--text);
        }
        
        .btn-light:hover {
            background: var(--border);
        }
        
        .btn-success { background: var(--success); border-color: var(--success); }
        .btn-danger { background: var(--danger); border-color: var(--danger); }
        .btn-warning { background: var(--warning); border-color: var(--warning); }
        .btn-info { background: var(--info); border-color: var(--info); }
        
        .editor-header {
            background: var(--background);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .file-name {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .file-name i {
            color: var(--primary);
        }
        
        .status-indicators {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.85rem;
            color: var(--secondary);
        }
        
        #autosave-indicator {
            font-size: 0.85rem;
            color: var(--secondary);
        }
        
        .word-counter {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.5rem;
            background: var(--light);
            border-radius: 4px;
            font-size: 0.85rem;
        }
        
        .toast-container {
            position: fixed;
            bottom: 1.25rem;
            right: 1.25rem;
            z-index: 9999;
        }
        
        .toast {
            background: var(--background);
            border-radius: 8px;
            box-shadow: 0 5px 15px var(--shadow);
            border: 1px solid var(--border);
            color: var(--text);
        }
        
        .toast-header {
            background: var(--background);
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }
        
        #tabs {
            display: flex;
            background: var(--background);
            border-bottom: 1px solid var(--border);
            padding: 0.5rem 0.75rem 0;
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: thin;
        }
        
        #tabs::-webkit-scrollbar {
            height: 5px;
        }
        
        #tabs::-webkit-scrollbar-track {
            background: var(--background);
        }
        
        #tabs::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }
        
        .tab {
            padding: 0.5rem 1rem;
            margin-right: 0.5rem;
            background: var(--light);
            border-radius: 6px 6px 0 0;
            cursor: pointer;
            position: relative;
            font-size: 0.9rem;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: all 0.2s;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .tab.active {
            background: var(--primary);
            color: white;
        }
        
        .tab .close {
            font-size: 1rem;
            line-height: 1;
            opacity: 0.7;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .tab .close:hover {
            opacity: 1;
        }
        
        .tab.active .close {
            color: white;
        }
        
        .new-tab {
            padding: 0.5rem;
            cursor: pointer;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .new-tab:hover {
            background: var(--light);
        }
        
        .modal-content {
            background: var(--background);
            border: 1px solid var(--border);
            color: var(--text);
        }
        
        .modal-header {
            border-bottom: 1px solid var(--border);
        }
        
        .modal-footer {
            border-top: 1px solid var(--border);
        }
        
        .form-control {
            background: var(--background);
            border: 1px solid var(--border);
            color: var(--text);
        }
        
        .form-control:focus {
            background: var(--background);
            color: var(--text);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .btn-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 10px var(--shadow);
        }
        
        .preview-toggle {
            position: fixed;
            bottom: 1.25rem;
            right: 1.25rem;
            z-index: 1010;
        }
        
        .theme-toggle {
            cursor: pointer;
            color: var(--text);
            font-size: 1.2rem;
            transition: all 0.2s ease;
        }
        
        .theme-toggle:hover {
            color: var(--primary);
        }
        
        /* Preview Content Styling */
        #preview h1, #preview h2, #preview h3 {
            color: var(--text);
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.5rem;
            margin-top: 1.5rem;
        }
        
        #preview h1:first-child, #preview h2:first-child, #preview h3:first-child {
            margin-top: 0;
        }
        
        #preview blockquote {
            border-left: 4px solid var(--primary);
            padding-left: 1rem;
            color: var(--secondary);
            margin: 1rem 0;
        }
        
        #preview code {
            background: var(--light);
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            font-family: 'Fira Code', monospace;
            font-size: 0.9rem;
        }
        
        #preview pre {
            background: var(--light);
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 1rem 0;
        }
        
        #preview pre code {
            background: transparent;
            padding: 0;
        }
        
        #preview ul, #preview ol {
            padding-left: 1.5rem;
        }
        
        #preview table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        
        #preview th, #preview td {
            padding: 0.5rem;
            border: 1px solid var(--border);
        }
        
        #preview th {
            background: var(--light);
        }
        
        #preview img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1rem 0;
        }
        
        #preview a {
            color: var(--primary);
            text-decoration: none;
        }
        
        #preview a:hover {
            text-decoration: underline;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .toolbar {
                padding: 0.25rem;
            }
            
            .toolbar-group {
                padding: 0 2px;
                gap: 2px;
            }
            
            .btn-icon {
                padding: 0.3rem 0.4rem;
                font-size: 0.8rem;
            }
            
            .preview-container {
                width: 85%;
            }
            
            .editor-container {
                height: calc(100vh - 150px);
            }
        }

        .reading-time {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0.5rem;
    background: var(--light);
    border-radius: 4px;
    font-size: 0.85rem;
}


    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
                <a class="navbar-brand" href="https://infinitytoolspace.com/">
                <i class="fas fa-pen-fancy me-2"></i>Elegant Notepad
             </a>
                <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light btn-sm" onclick="showHelpModal()" title="Help">
                <i class="fas fa-info-circle"></i>
                </button>
                <div class="theme-toggle" onclick="toggleTheme()">
                    <i class="fas fa-moon"></i>
                </div>
                <button class="btn btn-light btn-sm" onclick="toggleFullscreen()">
                    <i class="fas fa-expand"></i>
                </button>

                
               </div>
               

        </div>
    </nav>


    <!-- Export Modal -->
<div class="modal fade" id="exportModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-export me-2"></i>Export Document</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-3">
                    <button class="btn btn-outline-primary" onclick="exportDocument('pdf')">
                        <i class="fas fa-file-pdf me-2"></i>Export as PDF
                    </button>
                    <button class="btn btn-outline-success" onclick="exportDocument('html')">
                        <i class="fas fa-file-code me-2"></i>Export as HTML
                    </button>
                    <button class="btn btn-outline-info" onclick="exportDocument('markdown')">
                        <i class="fas fa-file-alt me-2"></i>Export as Markdown (.md)
                    </button>
                    <button class="btn btn-outline-secondary" onclick="exportDocument('text')">
                        <i class="fas fa-file-alt me-2"></i>Export as Plain Text
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

    <div class="container mt-3 mb-4">
        <div class="toolbar">
            <!-- Text Formatting Group -->
            <div class="toolbar-group">
                <button class="btn btn-light btn-icon" onclick="formatText('**', '**')" title="Bold">
                    <i class="fas fa-bold"></i>
                </button>
                <button class="btn btn-light btn-icon" onclick="formatText('*', '*')" title="Italic">
                    <i class="fas fa-italic"></i>
                </button>
                <button class="btn btn-light btn-icon" onclick="formatText('~~', '~~')" title="Strikethrough">
                    <i class="fas fa-strikethrough"></i>
                </button>
            </div>
            
            <!-- Heading Group -->
            <div class="toolbar-group">
                <button class="btn btn-light btn-icon" onclick="formatText('# ', '')" title="Heading 1">
                    <i class="fas fa-heading"></i><small>1</small>
                </button>
                <button class="btn btn-light btn-icon" onclick="formatText('## ', '')" title="Heading 2">
                    <i class="fas fa-heading"></i><small>2</small>
                </button>
                <button class="btn btn-light btn-icon" onclick="formatText('### ', '')" title="Heading 3">
                    <i class="fas fa-heading"></i><small>3</small>
                </button>
            </div>
            
            <!-- List Group -->
            <div class="toolbar-group">
                <button class="btn btn-light btn-icon" onclick="insertList('unordered')" title="Bullet List">
                    <i class="fas fa-list-ul"></i>
                </button>
                <button class="btn btn-light btn-icon" onclick="insertList('ordered')" title="Numbered List">
                    <i class="fas fa-list-ol"></i>
                </button>
                <button class="btn btn-light btn-icon" onclick="insertList('task')" title="Task List">
                    <i class="fas fa-tasks"></i>
                </button>
            </div>
            
            <!-- Element Group -->
            <div class="toolbar-group">
                <button class="btn btn-light btn-icon" onclick="formatText('> ', '')" title="Quote">
                    <i class="fas fa-quote-right"></i>
                </button>
                <button class="btn btn-light btn-icon" onclick="insertLink()" title="Link">
                    <i class="fas fa-link"></i>
                </button>
                <button class="btn btn-light btn-icon" onclick="formatText('![Image description](', ')')" title="Image">
                    <i class="fas fa-image"></i>
                </button>
                <button class="btn btn-light btn-icon" onclick="insertTable()" title="Table">
                    <i class="fas fa-table"></i>
                </button>
            </div>
            
            <!-- Code Group -->
            <div class="toolbar-group">
                <button class="btn btn-light btn-icon" onclick="formatText('`', '`')" title="Inline Code">
                    <i class="fas fa-code"></i>
                </button>
                <button class="btn btn-light btn-icon" onclick="insertCodeBlock()" title="Code Block">
                    <i class="fas fa-file-code"></i>
                </button>
            </div>

            <!-- Tag group -->
            <div class="toolbar-group">
            <div class="tags-container">
    <div class="tags" id="tagContainer"></div>
    <button class="btn btn-sm btn-light" onclick="showTagModal()">
        <i class="fas fa-tags"></i>
    </button>
</div>
            </div>
            
            <!-- File Operations -->
            <div class="toolbar-group ms-auto">
                <button class="btn btn-info btn-icon" data-bs-toggle="modal" data-bs-target="#findModal" title="Find & Replace">
                    <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-success btn-icon" onclick="saveFile()" title="Save">
                    <i class="fas fa-save"></i>
                </button>
                <button class="btn btn-warning btn-icon" onclick="showExportModal()" title="Export">
    <i class="fas fa-file-export"></i>
</button>
                <button class="btn btn-danger btn-icon" onclick="newFile()" title="New File">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>

        <div id="tabs">
            <?php foreach ($files as $file): ?>
                <div class="tab <?= $current_file === basename($file) ? 'active' : '' ?>" 
                     onclick="openFile('<?= basename($file) ?>')">
                    <i class="fas fa-file-alt"></i>
                    <?= basename($file) ?>
                    <span class="close" onclick="deleteFile(event, '<?= basename($file) ?>')">×</span>
                </div>
            <?php endforeach; ?>
            <div class="new-tab" onclick="newFile()"><i class="fas fa-plus"></i></div>
        </div>

        <div class="editor-container">
            <div class="editor-header">
                <div class="file-name">
                    <i class="fas fa-file-alt"></i>
                    <span id="file-name"><?= $current_file ?: 'Untitled' ?></span>
                </div>
                <div class="status-indicators">
                    <div id="autosave-indicator"></div>
                    <div class="word-counter">
                        <i class="fas fa-font"></i> <span id="wordCount">0</span> words
                        <i class="fas fa-text-width ms-2"></i> <span id="charCount">0</span> chars
                    </div>
                    <div class="reading-time">
    <i class="fas fa-book-reader"></i> <span id="readingTime">0 minutes</span>
</div>
                </div>
            </div>
            <textarea id="editor" placeholder="Start typing here..."><?= htmlspecialchars($current_content) ?></textarea>
        </div>
    </div>

    <!-- Preview Toggle Button -->
    <div class="preview-toggle">
        <button class="btn btn-primary btn-circle" onclick="togglePreview()" title="Toggle Preview">
            <i class="fas fa-eye"></i>
        </button>
    </div>

    <!-- Preview Container -->
    <div class="preview-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="m-0">Preview</h5>
            <button class="btn-close" onclick="togglePreview()"></button>
        </div>
        <div id="preview"></div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="findModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Find & Replace</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="findText" class="form-label">Find</label>
                        <input type="text" id="findText" class="form-control" placeholder="Text to find...">
                    </div>
                    <div class="mb-3">
                        <label for="replaceText" class="form-label">Replace with</label>
                        <input type="text" id="replaceText" class="form-control" placeholder="Replacement text...">
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="caseSensitive">
                        <label class="form-check-label" for="caseSensitive">
                            Case sensitive
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" onclick="findText()">Find</button>
                    <button class="btn btn-success" onclick="findReplace()">Replace All</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tags Modal -->
<div class="modal fade" id="tagsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-tags me-2"></i>Manage Tags</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="tagInput" class="form-label">Add tags (comma separated)</label>
                    <input type="text" id="tagInput" class="form-control" value="<?= htmlspecialchars($current_tags) ?>">
                </div>
                <div class="mt-3" id="tagSuggestions">
                    <h6>Suggested Tags</h6>
                    <div class="d-flex flex-wrap gap-2" id="suggestedTags">
                        <!-- Tags will be inserted here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" onclick="saveTags()">Save Tags</button>
            </div>
        </div>
    </div>
</div>

    <!-- Toast notifications -->
    <div class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/4.0.2/marked.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // DOM Elements
        const editor = document.getElementById('editor');
        const preview = document.getElementById('preview');
        const wordCountEl = document.getElementById('wordCount');
        const charCountEl = document.getElementById('charCount');
        const autosaveIndicator = document.getElementById('autosave-indicator');
        const previewContainer = document.querySelector('.preview-container');
        
        // Variables
        let currentFile = '<?= $current_file ?>';
        let autosaveTimer;
        let lastSavedContent = editor.value;
        let isDarkMode = localStorage.getItem('darkMode') === 'true';
        let previewVisible = false;
        
        // Apply dark mode if set
        if (isDarkMode) {
            document.body.classList.add('dark-mode');
            document.querySelector('.theme-toggle i').classList.replace('fa-moon', 'fa-sun');
        }
        
        // Initialize
        updatePreview();
        updateWordCount();
        
        // Event Listeners
        editor.addEventListener('input', () => {
            updatePreview();
            updateWordCount();
            
            // Set up autosave
            clearTimeout(autosaveTimer);
            autosaveIndicator.textContent = 'Editing...';
            autosaveTimer = setTimeout(() => {
                if (currentFile && editor.value !== lastSavedContent) {
                    autoSave();
                } else {
                    autosaveIndicator.textContent = '';
                }
            }, 2000);
        });

        // Replace the exportPDF function with:
function showExportModal() {
    const modal = new bootstrap.Modal(document.getElementById('exportModal'));
    modal.show();
}

let currentTags = "<?= htmlspecialchars($current_tags) ?>".split(',').filter(tag => tag.trim() !== '');
const suggestedTagsList = ['personal', 'work', 'todo', 'ideas', 'project', 'meeting', 'journal'];

function renderTags() {
    const container = document.getElementById('tagContainer');
    container.innerHTML = '';
    
    currentTags.forEach(tag => {
        const tagEl = document.createElement('span');
        tagEl.className = 'tag';
        tagEl.textContent = tag.trim();
        container.appendChild(tagEl);
    });
}

function showTagModal() {
    // Generate suggested tags
    const suggestedContainer = document.getElementById('suggestedTags');
    suggestedContainer.innerHTML = '';
    
    suggestedTagsList.forEach(tag => {
        if (!currentTags.includes(tag)) {
            const tagBtn = document.createElement('button');
            tagBtn.className = 'btn btn-sm btn-outline-secondary';
            tagBtn.textContent = tag;
            tagBtn.onclick = () => addSuggestedTag(tag);
            suggestedContainer.appendChild(tagBtn);
        }
    });
    
    document.getElementById('tagInput').value = currentTags.join(', ');
    const modal = new bootstrap.Modal(document.getElementById('tagsModal'));
    modal.show();
}

function addSuggestedTag(tag) {
    const input = document.getElementById('tagInput');
    const currentValue = input.value.trim();
    input.value = currentValue ? `${currentValue}, ${tag}` : tag;
}

function saveTags() {
    const tagsInput = document.getElementById('tagInput').value;
    currentTags = tagsInput.split(',').map(tag => tag.trim()).filter(tag => tag !== '');
    
    // Update the editor content to include tags
    if (currentTags.length > 0) {
        const contentWithoutTags = editor.value.replace(/^Tags:.*\n/, '');
        editor.value = `Tags: ${currentTags.join(', ')}\n${contentWithoutTags}`;
    } else {
        editor.value = editor.value.replace(/^Tags:.*\n/, '');
    }
    
    renderTags();
    const modal = bootstrap.Modal.getInstance(document.getElementById('tagsModal'));
    modal.hide();
    updatePreview();
    autoSave();
}

// Initialize tags
renderTags();

// Add this function to your JavaScript:
function updateReadingTime() {
    const text = editor.value;
    const words = text.trim() ? text.trim().split(/\s+/).length : 0;
    
    // Average reading speed: 200-250 words per minute
    const readingSpeed = 225;
    const minutes = Math.ceil(words / readingSpeed);
    
    let readingTime = '';
    if (minutes < 1 && words > 0) {
        readingTime = 'Less than a minute';
    } else if (minutes === 1) {
        readingTime = '1 minute';
    } else {
        readingTime = `${minutes} minutes`;
    }
    
    // Add reading time to status indicators
    const readingTimeEl = document.getElementById('readingTime');
    readingTimeEl.textContent = readingTime;
}

// Call this in your editor input event listener:
updateReadingTime();

// Initialize on page load:
updateReadingTime();

function exportDocument(format) {
    const content = editor.value;
    const filename = currentFile ? currentFile.replace('.txt', '') : 'document';
    
    switch(format) {
        case 'pdf':
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const plainText = content;
            const lines = doc.splitTextToSize(plainText, 180);
            doc.text(lines, 15, 15);
            doc.save(filename + '.pdf');
            break;
            
        case 'html':
            const htmlContent = marked.parse(content);
            const htmlBlob = new Blob([`<!DOCTYPE html>
                <html>
                <head>
                    <title>${filename}</title>
                    <meta charset="utf-8">
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }
                        img { max-width: 100%; }
                        pre { background: #f4f4f4; padding: 10px; border-radius: 5px; overflow-x: auto; }
                        blockquote { border-left: 4px solid #ddd; padding-left: 15px; color: #777; }
                    </style>
                </head>
                <body>
                    ${htmlContent}
                </body>
                </html>`], {type: 'text/html'});
            downloadBlob(htmlBlob, filename + '.html');
            break;
            
        case 'markdown':
            const markdownBlob = new Blob([content], {type: 'text/markdown'});
            downloadBlob(markdownBlob, filename + '.md');
            break;
            
        case 'text':
            const textBlob = new Blob([content], {type: 'text/plain'});
            downloadBlob(textBlob, filename + '.txt');
            break;
    }
    
    showToast(`Exported as ${format.toUpperCase()} successfully!`, 'success');
}

function downloadBlob(blob, filename) {
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    setTimeout(() => {
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }, 100);
}
        
        // Functions
        function updatePreview() {
            preview.innerHTML = marked.parse(editor.value);
        }
        
        function updateWordCount() {
            const text = editor.value;
            const words = text.trim() ? text.trim().split(/\s+/).length : 0;
            const chars = text.length;
            
            wordCountEl.textContent = words;
            charCountEl.textContent = chars;
        }
        
        function togglePreview() {
            previewVisible = !previewVisible;
            updatePreview();
            previewContainer.classList.toggle('active', previewVisible);
            document.querySelector('.preview-toggle i').classList.toggle('fa-eye', !previewVisible);
            document.querySelector('.preview-toggle i').classList.toggle('fa-eye-slash', previewVisible);
        }
        
        function toggleTheme() {
            isDarkMode = !isDarkMode;
            document.body.classList.toggle('dark-mode', isDarkMode);
            localStorage.setItem('darkMode', isDarkMode);
            
            const themeIcon = document.querySelector('.theme-toggle i');
            if (isDarkMode) {
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            } else {
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            }
        }

        // Text formatting
        function formatText(prefix, suffix = '') {
            const start = editor.selectionStart;
            const end = editor.selectionEnd;
            const selectedText = editor.value.substring(start, end);
            
            editor.value = editor.value.substring(0, start) + 
                           prefix + selectedText + suffix + 
                           editor.value.substring(end);
            
            editor.focus();
            updatePreview();
            updateWordCount();
            
            // Set cursor position after insertion
            const newCursorPos = selectedText.length > 0 ? 
                                 end + prefix.length + suffix.length : 
                                 start + prefix.length;
            editor.setSelectionRange(newCursorPos, newCursorPos);
        }
        
        function insertList(type) {
            let listText = '';
            
            switch(type) {
                case 'unordered':
                    listText = "\n- Item 1\n- Item 2\n- Item 3\n";
                    break;
                case 'ordered':
                    listText = "\n1. Item 1\n2. Item 2\n3. Item 3\n";
                    break;
                case 'task':
                    listText = "\n- [ ] Task 1\n- [ ] Task 2\n- [x] Completed task\n";
                    break;
                default:
                    listText = "\n- Item 1\n- Item 2\n- Item 3\n";
            }
            
            formatText(listText, '');
        }
        
        function insertLink() {
            const selectedText = editor.value.substring(editor.selectionStart, editor.selectionEnd) || "Link text";
            formatText(`[${selectedText}](`, ")");
        }
        
        function insertCodeBlock() {
            formatText("```\n", "\n```");
        }
        
        function insertTable() {
            const tableTemplate = `
| Header 1 | Header 2 | Header 3 |
|----------|----------|----------|
| Cell 1   | Cell 2   | Cell 3   |
| Cell 4   | Cell 5   | Cell 6   |
`;
            formatText(tableTemplate, '');
        }

        // File operations
        function newFile() {
            currentFile = '';
            editor.value = '';
            document.getElementById('file-name').textContent = 'Untitled';
            updatePreview();
            updateWordCount();
            lastSavedContent = '';
            
            // Update active tab
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));
        }
        
        function openFile(filename) {
            window.location.href = `?file=${filename}`;
        }
        
        function saveFile() {
            let filename = currentFile;
            if (!filename) {
                filename = prompt('Enter filename:', 'note.txt');
                if (!filename) return;
            }
            
            const formData = new FormData();
            formData.append('action', 'save');
            formData.append('filename', filename);
            formData.append('content', editor.value);
            
            fetch('', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        showToast(`File "${data.filename}" saved successfully!`, 'success');
                        currentFile = data.filename;
                        document.getElementById('file-name').textContent = data.filename;
                        lastSavedContent = editor.value;
                        autosaveIndicator.textContent = 'Saved';
                        setTimeout(() => {
                            autosaveIndicator.textContent = '';
                        }, 1500);
                        
                        // Refresh page to update tabs
                        window.location.href = `?file=${data.filename}`;
                    }
                });
        }
        
        function autoSave() {
            if (!currentFile) return;
            
            const formData = new FormData();
            formData.append('action', 'save');
            formData.append('filename', currentFile);
            formData.append('content', editor.value);
            
            fetch('', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        lastSavedContent = editor.value;
                        autosaveIndicator.textContent = 'Saved';
                        setTimeout(() => {
                            autosaveIndicator.textContent = '';
                        }, 1500);
                    }
                });
        }
        
        function deleteFile(e, filename) {
            e.stopPropagation();
            if (!confirm(`Delete "${filename}"?`)) return;
            
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('filename', filename);
            
            fetch('', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        showToast(`File "${filename}" deleted`, 'danger');
                        
                        // If the current file is deleted, create a new file
                        if (currentFile === filename) {
                            newFile();
                        }
                        
                        // Remove tab
                        const tab = e.target.parentElement;
                        tab.remove();
                    }
                });
        }

        // Export PDF
        function exportPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            const filename = currentFile ? currentFile.replace('.txt', '.pdf') : 'document.pdf';
            const text = editor.value;
            
            // Use marked to convert markdown to HTML
            const htmlContent = marked.parse(text);
            
            // Simple text export (for now)
            const plainText = htmlContent.replace(/<[^>]*>/g, '');
            const lines = doc.splitTextToSize(plainText, 180);
            doc.text(lines, 15, 15);
            
            doc.save(filename);
            showToast('PDF exported successfully!', 'success');
        }

        // Fullscreen
        function toggleFullscreen() {
            const container = document.querySelector('.editor-container');
            container.classList.toggle('fullscreen');
            
            const icon = document.querySelector('.navbar .fa-expand');
            if (container.classList.contains('fullscreen')) {
                document.body.style.overflow = 'hidden';
                icon.classList.replace('fa-expand', 'fa-compress');
            } else {
                document.body.style.overflow = 'auto';
                icon.classList.replace('fa-compress', 'fa-expand');
            }
        }

        // Find & Replace
        function findText() {
            const searchText = document.getElementById('findText').value;
            if (!searchText) return;
            
            const caseSensitive = document.getElementById('caseSensitive').checked;
            const text = editor.value;
            const regex = new RegExp(searchText, caseSensitive ? 'g' : 'gi');
            const matches = text.match(regex);
            
            if (matches) {
                showToast(`Found ${matches.length} matches`, 'info');
                
                // Find first occurrence and select it
                const index = caseSensitive ? 
                    text.indexOf(searchText) : 
                    text.toLowerCase().indexOf(searchText.toLowerCase());
                    
                if (index !== -1) {
                    editor.focus();
                    editor.setSelectionRange(index, index + searchText.length);
                }
            } else {
                showToast('No matches found', 'warning');
            }
        }
        
        function findReplace() {
            const find = document.getElementById('findText').value;
            const replace = document.getElementById('replaceText').value;
            const caseSensitive = document.getElementById('caseSensitive').checked;
            
            if (find) {
                const originalText = editor.value;
                let newText;
                let count = 0;
                
                if (caseSensitive) {
                    const regex = new RegExp(find, 'g');
                    count = (originalText.match(regex) || []).length;
                    newText = originalText.replace(regex, replace);
                } else {
                    // Case-insensitive replace requires more complex handling
                    const regex = new RegExp(find, 'gi');
                    count = (originalText.match(regex) || []).length;
                    newText = originalText.replace(regex, replace);
                }
                
                editor.value = newText;
                updatePreview();
                updateWordCount();
                
                showToast(`Replaced ${count} occurrences`, 'success');
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('findModal'));
                modal.hide();
            }
        }
        
        // Toast notifications
        function showToast(message, type = 'primary') {
            const toastContainer = document.querySelector('.toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast show';
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            const iconMap = {
                'success': 'fa-check-circle',
                'danger': 'fa-exclamation-circle',
                'warning': 'fa-exclamation-triangle',
                'info': 'fa-info-circle',
                'primary': 'fa-bell'
            };
            
            const icon = iconMap[type] || iconMap.primary;
            
            toast.innerHTML = `
                <div class="toast-header">
                    <i class="fas ${icon} me-2 text-${type}"></i>
                    <strong class="me-auto">Notification</strong>
                    <small>just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toastContainer.removeChild(toast);
                }, 300);
            }, 3000);
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                saveFile();
            } else if (e.ctrlKey && e.key === 'n') {
                e.preventDefault();
                newFile();
            } else if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                const modal = new bootstrap.Modal(document.getElementById('findModal'));
                modal.show();
            } else if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                togglePreview();
            } else if (e.key === 'Escape' && previewVisible) {
                togglePreview();
            }
        });

        function showHelpModal() {
    const modal = new bootstrap.Modal(document.getElementById('helpModal'));
    modal.show();
}
    </script>

    <!-- Help Modal -->
<div class="modal fade" id="helpModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-question-circle me-2"></i>How to Use Elegant Notepad</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="helpAccordion">
                    <!-- Basic Editing -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#basicEditing">
                                <i class="fas fa-edit me-2"></i>Basic Editing
                            </button>
                        </h2>
                        <div id="basicEditing" class="accordion-collapse collapse show" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <h6>Text Formatting</h6>
                                <ul>
                                    <li><strong>Bold Text</strong>: Select text and click the <i class="fas fa-bold"></i> button, or use <code>**text**</code></li>
                                    <li><em>Italic Text</em>: Select text and click the <i class="fas fa-italic"></i> button, or use <code>*text*</code></li>
                                    <li><s>Strikethrough</s>: Select text and click the <i class="fas fa-strikethrough"></i> button, or use <code>~~text~~</code></li>
                                </ul>
                                
                                <h6>Headings</h6>
                                <ul>
                                    <li>Use <i class="fas fa-heading"></i><small>1</small> for Heading 1 <code># Heading</code></li>
                                    <li>Use <i class="fas fa-heading"></i><small>2</small> for Heading 2 <code>## Heading</code></li>
                                    <li>Use <i class="fas fa-heading"></i><small>3</small> for Heading 3 <code>### Heading</code></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lists -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#listsHelp">
                                <i class="fas fa-list me-2"></i>Lists
                            </button>
                        </h2>
                        <div id="listsHelp" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li>Click <i class="fas fa-list-ul"></i> to insert a bullet list</li>
                                    <li>Click <i class="fas fa-list-ol"></i> to insert a numbered list</li>
                                    <li>Click <i class="fas fa-tasks"></i> to insert a task list with checkboxes</li>
                                </ul>
                                <div class="alert alert-info">
                                    You can also type <code>- item</code> for bullet lists, <code>1. item</code> for numbered lists, or <code>- [ ] task</code> for task lists
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Elements -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#elementsHelp">
                                <i class="fas fa-object-group me-2"></i>Elements
                            </button>
                        </h2>
                        <div id="elementsHelp" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li><i class="fas fa-quote-right"></i> - Insert a blockquote (<code>> Quote text</code>)</li>
                                    <li><i class="fas fa-link"></i> - Insert a link (<code>[Link text](URL)</code>)</li>
                                    <li><i class="fas fa-image"></i> - Insert an image (<code>![Alt text](image-url)</code>)</li>
                                    <li><i class="fas fa-table"></i> - Insert a table structure</li>
                                    <li><i class="fas fa-code"></i> - Insert inline code with backticks (<code>`code`</code>)</li>
                                    <li><i class="fas fa-file-code"></i> - Insert a code block (<code>```code```</code>)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- File Operations -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fileOpsHelp">
                                <i class="fas fa-folder me-2"></i>File Operations
                            </button>
                        </h2>
                        <div id="fileOpsHelp" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li><i class="fas fa-plus"></i> - Create a new file</li>
                                    <li><i class="fas fa-save"></i> - Save the current file</li>
                                    <li><i class="fas fa-file-pdf"></i> - Export the current file as PDF</li>
                                    <li>Click on a tab to switch between files</li>
                                    <li>Click the × on a tab to delete a file (with confirmation)</li>
                                </ul>
                                <div class="alert alert-success">
                                    <strong>Pro tip:</strong> Your files are automatically saved as you type!
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tools -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#toolsHelp">
                                <i class="fas fa-tools me-2"></i>Tools & Features
                            </button>
                        </h2>
                        <div id="toolsHelp" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li><i class="fas fa-search"></i> - Find and replace text</li>
                                    <li><i class="fas fa-eye"></i> - Toggle preview mode to see rendered markdown</li>
                                    <li><i class="fas fa-moon"></i>/<i class="fas fa-sun"></i> - Toggle between light and dark mode</li>
                                    <li><i class="fas fa-expand"></i> - Toggle fullscreen mode</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Keyboard Shortcuts -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shortcutsHelp">
                                <i class="fas fa-keyboard me-2"></i>Keyboard Shortcuts
                            </button>
                        </h2>
                        <div id="shortcutsHelp" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li><kbd>Ctrl</kbd> + <kbd>S</kbd> - Save file</li>
                                            <li><kbd>Ctrl</kbd> + <kbd>N</kbd> - New file</li>
                                            <li><kbd>Ctrl</kbd> + <kbd>F</kbd> - Find and replace</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li><kbd>Ctrl</kbd> + <kbd>P</kbd> - Toggle preview</li>
                                            <li><kbd>Esc</kbd> - Close preview if open</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "Online Notepad",
  "url": "https://infinitytoolspace.com/tools/notepad",
  "description": "Write and save notes instantly using our free browser-based notepad. No sign-up required. Ideal for quick ideas, drafts, and daily use.",
  "applicationCategory": "Productivity",
  "operatingSystem": "All",
  "browserRequirements": "Modern browser",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjCP_jgM4f3f-1cA7IL2B6zFzqOtw_H4-qHsy3NMfhvQG-Lu-3IXwWMaBjSFyRYBB0KBBg7HTAs9Gb6CO5Tn0Xtb1WWblHwskz57A1SkGXDTWFRB12iMwCmAQ6qH40y68ELpEwFlzucu9WXCAH4v5uCRjvOLx_t7AzU13woMQBH1OsjmD-chV_yb-6JXI8/s16000/Heading%20(5).png"
}
</script>

</body>
</html>