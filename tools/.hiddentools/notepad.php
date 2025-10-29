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
    <!-- SEO Meta Tags -->
<meta name="description" content="Modern Notepad - A premium markdown editor with real-time preview, file management, and sharing capabilities.">
<meta name="keywords" content="notepad, markdown editor, text editor, online notes, share notes, premium editor">
<meta name="author" content="InfinityToolSpace - Modern Notepad">
<meta property="og:title" content="Modern Notepad - Premium Markdown Editor">
<meta property="og:description" content="Create, edit, and share markdown notes with this beautiful and feature-rich online notepad.">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>">
<meta name="twitter:card" content="summary_large_image">
<link rel="canonical" href="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>">

    <title>Modern Notepad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3a86ff;
            --secondary: #8338ec;
            --accent: #ff006e;
            --success: #06d6a0;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
        }
        
        .navbar {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .editor-container, .preview-area {
            height: 80vh;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            background: white;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        #editor {
            height: 100%;
            width: 100%;
            border: none;
            padding: 20px;
            font-family: 'Cascadia Code', 'Fira Code', monospace;
            font-size: 16px;
            line-height: 1.6;
            resize: none;
            background: rgba(255,255,255,0.8);
        }
        
        #editor:focus { outline: none; }
        
        .preview-area {
            padding: 20px;
            overflow-y: auto;
        }
        
        .toolbar {
            background: white;
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .toolbar-btn {
            border-radius: 8px;
            transition: all 0.2s;
            border: none;
        }
        
        .toolbar-btn:hover { transform: translateY(-2px); }
        
        .btn-primary { background: var(--primary); }
        .btn-success { background: var(--success); }
        .btn-info { background: var(--secondary); color: white; }
        
        .fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            width: 100vw !important;
            height: 100vh !important;
            border-radius: 0;
        }
        
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        #preview h1, #preview h2, #preview h3 {
            color: var(--dark);
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        #preview blockquote {
            border-left: 4px solid var(--primary);
            padding-left: 15px;
            color: #666;
        }
        
        #preview code {
            background: #f4f6f8;
            padding: 2px 5px;
            border-radius: 4px;
        }
        
        #preview pre {
            background: #f4f6f8;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
        }
        
        .editor-header {
            background: #f8f9fa;
            padding: 8px 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .word-counter {
            font-size: 14px;
            color: #666;
        }
        
        #tabs {
            display: flex;
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 8px 10px 0;
            overflow-x: auto;
            white-space: nowrap;
        }
        
        .tab {
            padding: 8px 15px;
            margin-right: 5px;
            background: #e9ecef;
            border-radius: 8px 8px 0 0;
            cursor: pointer;
            position: relative;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .tab.active {
            background: white;
            font-weight: 500;
        }
        
        .tab .close {
            margin-left: 8px;
            font-size: 14px;
            opacity: 0.5;
        }
        
        .tab .close:hover {
            opacity: 1;
        }
        
        .new-tab {
            padding: 8px;
            cursor: pointer;
            color: var(--primary);
        }
        
        #autosave-indicator {
            font-size: 12px;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .preview-area {
                height: auto;
                min-height: 300px;
                margin-top: 15px;
            }
        }
        
        
        
.navbar {
  background: var(--primary);
}

.btn-primary, .btn-success, .btn-info {
  transition: all 0.3s ease;
}

.btn-primary:hover, .btn-success:hover, .btn-info:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.tab.active {
  background: #ffffff;
  box-shadow: 0 -3px 6px rgba(0,0,0,0.05);
}

.editor-container, .preview-area {
  backdrop-filter: blur(10px);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.editor-container:hover, .preview-area:hover {
  transform: translateY(-3px);
}


/* Loading animations */
.loading-spinner {
  display: inline-block;
  width: 20px;
  height: 20px;
  border: 2px solid rgba(0,0,0,0.1);
  border-radius: 50%;
  border-top-color: var(--primary);
  animation: spin 0.8s ease infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: #c7d2fe;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #a5b4fc;
}


/* Add these styles to your existing CSS in the <style> section */
#preview table {
  border-collapse: collapse;
  width: 100%;
  margin: 15px 0;
}

#preview th,
#preview td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

#preview th {
  background-color: #f8f9fa;
  font-weight: bold;
}

#preview tr:nth-child(even) {
  background-color: #f9f9f9;
}

#preview tr:hover {
  background-color: #f1f5f9;
}

        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-edit me-2"></i>Modern Notepad
            </a>
            
            <div class="d-flex align-items-center">
                <button class="btn btn-light btn-sm" onclick="toggleFullscreen()">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        
    </nav>

    <div class="container mt-4 mb-4">
        <div class="toolbar">
            <button class="btn btn-primary toolbar-btn" onclick="formatText('**', '**')"><i class="fas fa-bold"></i></button>
            <button class="btn btn-primary toolbar-btn" onclick="formatText('*', '*')"><i class="fas fa-italic"></i></button>
            <button class="btn btn-primary toolbar-btn" onclick="formatText('## ', '')"><i class="fas fa-heading"></i></button>
            <button class="btn btn-primary toolbar-btn" onclick="formatText('> ', '')"><i class="fas fa-quote-right"></i></button>
            <button class="btn btn-primary toolbar-btn" onclick="insertList()"><i class="fas fa-list-ul"></i></button>
            <button class="btn btn-primary toolbar-btn" onclick="insertLink()"><i class="fas fa-link"></i></button>
            <button class="btn btn-primary toolbar-btn" onclick="formatText('`', '`')"><i class="fas fa-code"></i></button>
            <button class="btn btn-primary toolbar-btn" onclick="formatText('![Alt text](', ')')"><i class="fas fa-image"></i></button>
            
            <button class="btn btn-primary toolbar-btn" onclick="insertTable()"><i class="fas fa-table"></i></button>
  <button class="btn btn-primary toolbar-btn" onclick="shareNote()"><i class="fas fa-share-alt"></i></button>
            
            <div class="ms-auto"></div>
            
            <button class="btn btn-success toolbar-btn" onclick="saveFile()"><i class="fas fa-save"></i></button>
            <button class="btn btn-info toolbar-btn" data-bs-toggle="modal" data-bs-target="#findModal">
                <i class="fas fa-search"></i>
            </button>
            <button class="btn btn-warning toolbar-btn" onclick="exportPDF()"><i class="fas fa-file-pdf"></i></button>
            <button class="btn btn-danger toolbar-btn" onclick="newFile()"><i class="fas fa-plus"></i></button>
        </div>

        <div id="tabs">
            <?php foreach ($files as $file): ?>
                <div class="tab <?= $current_file === basename($file) ? 'active' : '' ?>" 
                     onclick="openFile('<?= basename($file) ?>')">
                    <?= basename($file) ?>
                    <span class="close" onclick="deleteFile(event, '<?= basename($file) ?>')">×</span>
                </div>
            <?php endforeach; ?>
            <div class="new-tab" onclick="newFile()"><i class="fas fa-plus"></i></div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="editor-container">
                    <div class="editor-header">
                        <div id="file-name"><?= $current_file ?: 'Untitled' ?></div>
                        <div class="d-flex align-items-center">
                            <span id="autosave-indicator" class="me-2"></span>
                            <span class="word-counter">
                                <span id="wordCount">0</span> words | <span id="charCount">0</span> chars
                            </span>
                        </div>
                    </div>
                    <textarea id="editor" placeholder="Start typing here..."><?= htmlspecialchars($current_content) ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="preview-area" id="preview"></div>
            </div>
        </div>
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
                    <input type="text" id="findText" class="form-control mb-2" placeholder="Find...">
                    <input type="text" id="replaceText" class="form-control mb-2" placeholder="Replace with...">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="findText()">Find</button>
                    <button class="btn btn-success" onclick="findReplace()">Replace All</button>
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
        const editor = document.getElementById('editor');
        const preview = document.getElementById('preview');
        const wordCountEl = document.getElementById('wordCount');
        const charCountEl = document.getElementById('charCount');
        const autosaveIndicator = document.getElementById('autosave-indicator');
        let currentFile = '<?= $current_file ?>';
        let autosaveTimer;
        let lastSavedContent = editor.value;
        
        // Real-time preview and word count
        editor.addEventListener('input', () => {
            preview.innerHTML = marked.parse(editor.value);
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
        
        // Initialize
        preview.innerHTML = marked.parse(editor.value);
        updateWordCount();
        
        function updateWordCount() {
            const text = editor.value;
            const words = text.trim() ? text.trim().split(/\s+/).length : 0;
            const chars = text.length;
            
            wordCountEl.textContent = words;
            charCountEl.textContent = chars;
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
            preview.innerHTML = marked.parse(editor.value);
            updateWordCount();
            
            // Set cursor position after insertion
            const newCursorPos = selectedText.length > 0 ? 
                                 end + prefix.length + suffix.length : 
                                 start + prefix.length;
            editor.setSelectionRange(newCursorPos, newCursorPos);
        }
        
        function insertList() {
            formatText("\n- Item 1\n- Item 2\n- Item 3\n");
        }
        
        function insertLink() {
            const selectedText = editor.value.substring(editor.selectionStart, editor.selectionEnd) || "Link text";
            formatText(`[${selectedText}](`, ")");
        }

        // File operations
        function newFile() {
            currentFile = '';
            editor.value = '';
            document.getElementById('file-name').textContent = 'Untitled';
            preview.innerHTML = '';
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
                        showToast(`File "${data.filename}" saved successfully!`);
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
                        showToast(`File "${filename}" deleted`);
                        
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
            
            // Simple text export
            const text = editor.value;
            const lines = doc.splitTextToSize(text, 180);
            doc.text(lines, 15, 15);
            
            const filename = currentFile ? currentFile.replace('.txt', '.pdf') : 'document.pdf';
            doc.save(filename);
            showToast('PDF exported successfully!');
        }

        // Fullscreen
        function toggleFullscreen() {
            const container = document.querySelector('.editor-container');
            container.classList.toggle('fullscreen');
            
            if (container.classList.contains('fullscreen')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }

        // Find & Replace
        function findText() {
            const searchText = document.getElementById('findText').value;
            if (!searchText) return;
            
            const text = editor.value;
            const regex = new RegExp(searchText, 'gi');
            const matches = text.match(regex);
            
            if (matches) {
                showToast(`Found ${matches.length} matches`);
                
                // Find first occurrence and select it
                const index = text.search(regex);
                if (index !== -1) {
                    editor.focus();
                    editor.setSelectionRange(index, index + searchText.length);
                }
            } else {
                showToast('No matches found');
            }
        }
        
        function findReplace() {
            const find = document.getElementById('findText').value;
            const replace = document.getElementById('replaceText').value;
            
            if (find) {
                const originalText = editor.value;
                const newText = originalText.replaceAll(find, replace);
                editor.value = newText;
                preview.innerHTML = marked.parse(editor.value);
                updateWordCount();
                
                const count = (originalText.match(new RegExp(find, 'g')) || []).length;
                showToast(`Replaced ${count} occurrences`);
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('findModal'));
                modal.hide();
            }
        }
        
        // Toast notifications
        function showToast(message) {
            const toastContainer = document.querySelector('.toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast show';
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            toast.innerHTML = `
                <div class="toast-header">
                    <strong class="me-auto">Notification</strong>
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
            }
        });
        
        
        // Table insertion functionality
function insertTable() {
  const rows = prompt('Number of rows:', '3');
  const cols = prompt('Number of columns:', '3');
  
  if (!rows || !cols) return;
  
  let tableText = "\n\n|";
  
  // Header row
  for (let i = 0; i < cols; i++) {
    tableText += ` Column ${i+1} |`;
  }
  
  // Header divider
  tableText += "\n|";
  for (let i = 0; i < cols; i++) {
    tableText += " --- |";
  }
  
  // Data rows
  for (let i = 0; i < rows; i++) {
    tableText += "\n|";
    for (let j = 0; j < cols; j++) {
      tableText += ` Data |`;
    }
  }
  
  formatText(tableText + "\n\n", "");
}

// Share note functionality
function shareNote() {
  if (!currentFile) {
    showToast("Please save your note first");
    return;
  }
  
  // Create a share modal
  const modal = document.createElement('div');
  modal.className = 'modal fade';
  modal.id = 'shareModal';
  modal.innerHTML = `
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Share "${currentFile}"</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Share Link</label>
            <div class="input-group">
              <input type="text" class="form-control" id="shareLink" 
                value="${window.location.origin + window.location.pathname}?file=${currentFile}" readonly>
              <button class="btn btn-outline-primary" onclick="copyShareLink()">
                <i class="fas fa-copy"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Share Options</label>
            <div class="d-flex gap-2">
              <button class="btn btn-primary" onclick="shareViaEmail()">
                <i class="fas fa-envelope me-1"></i> Email
              </button>
              <button class="btn btn-info" onclick="shareWhatsApp()">
                <i class="fab fa-whatsapp me-1"></i> WhatsApp
              </button>
              <button class="btn btn-secondary" onclick="shareTelegram()">
                <i class="fab fa-telegram me-1"></i> Telegram
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
  
  document.body.appendChild(modal);
  const bsModal = new bootstrap.Modal(modal);
  bsModal.show();
  
  // Remove modal from DOM when hidden
  modal.addEventListener('hidden.bs.modal', function () {
    document.body.removeChild(modal);
  });
}

function copyShareLink() {
  const linkInput = document.getElementById('shareLink');
  linkInput.select();
  document.execCommand('copy');
  showToast('Link copied to clipboard!');
}

function shareViaEmail() {
  const subject = encodeURIComponent(`Check out my note: ${currentFile}`);
  const body = encodeURIComponent(`Here's a note I wanted to share with you: ${window.location.origin + window.location.pathname}?file=${currentFile}`);
  window.open(`mailto:?subject=${subject}&body=${body}`);
}

function shareWhatsApp() {
  const text = encodeURIComponent(`Check out my note: ${window.location.origin + window.location.pathname}?file=${currentFile}`);
  window.open(`https://wa.me/?text=${text}`);
}

function shareTelegram() {
  const text = encodeURIComponent(`Check out my note: ${window.location.origin + window.location.pathname}?file=${currentFile}`);
  window.open(`https://t.me/share/url?url=${window.location.origin + window.location.pathname}?file=${currentFile}&text=Check out my note!`);
}
    </script>
</body>
</html>
<?php
include("../footer.php")?>