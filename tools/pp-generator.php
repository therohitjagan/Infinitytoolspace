<?php
// Enhanced sanitization function
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

$policy_content = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $inputs = [
        'app_name' => sanitizeInput($_POST['app_name']),
        'developer_name' => sanitizeInput($_POST['developer_name']),
        'contact_email' => filter_input(INPUT_POST, 'contact_email', FILTER_SANITIZE_EMAIL),
        'website_url' => filter_input(INPUT_POST, 'website_url', FILTER_SANITIZE_URL),
        'data_types' => isset($_POST['data_types']) ? array_map('sanitizeInput', $_POST['data_types']) : [],
        'third_party_services' => sanitizeInput($_POST['third_party_services']),
        'country' => sanitizeInput($_POST['country'] ?? ''),
        'data_retention' => isset($_POST['data_retention']) ? sanitizeInput($_POST['data_retention']) : '30 days',
        'coppa_compliant' => isset($_POST['coppa_compliant']) ? true : false,
        'data_deletion' => isset($_POST['data_deletion']) ? true : false,
        'security_practices' => isset($_POST['security_practices']) ? $_POST['security_practices'] : []
    ];

    // Policy template with all Play Console requirements
    $policy_content = <<<EOD
# Privacy Policy for {$inputs['app_name']}

**Last Updated:** [Date]

{$inputs['developer_name']} ("we," "us," or "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our mobile application {$inputs['app_name']} (the "App"). 

## 1. Information Collection

We collect following types of information:

EOD;

    if (!empty($inputs['data_types'])) {
        foreach ($inputs['data_types'] as $type) {
            $policy_content .= "- $type\n";
        }
    }

    $policy_content .= <<<EOD

## 2. Data Usage

We use collected information to:
- Provide and maintain App functionality
- Improve user experience and develop new features
- Personalize content and recommendations
- Process transactions and send notifications
- Comply with legal obligations

## 3. Data Sharing & Disclosure

We may share information with:
- Third-party service providers: {$inputs['third_party_services']}
- Business partners and affiliates
- Legal authorities when required by law
- Successor entities in case of merger/acquisition

## 4. Data Security

We implement security measures including:
EOD;

    if (!empty($inputs['security_practices'])) {
        foreach ($inputs['security_practices'] as $practice) {
            $policy_content .= "- $practice\n";
        }
    } else {
        $policy_content .= "- Industry-standard encryption and access controls\n";
    }

    $policy_content .= <<<EOD

## 5. Data Retention

We retain personal data for {$inputs['data_retention']} unless required otherwise by law. Aggregated data may be stored indefinitely.

## 6. User Rights

Depending on your jurisdiction ({$inputs['country']}), you may have rights to:
- Access and request copy of your data
- Rectify inaccurate information
- Request deletion of personal data
- Restrict or object to data processing
- Data portability
- Withdraw consent

EOD;

    if ($inputs['data_deletion']) {
        $policy_content .= "To exercise these rights, contact us through the App settings or via provided contact information.\n\n";
    }

    if ($inputs['coppa_compliant']) {
        $policy_content .= "## 7. Children's Privacy\n";
        $policy_content .= "Our App does not knowingly collect information from children under 13. If we discover such data, we will promptly delete it.\n\n";
    }

    $policy_content .= <<<EOD
## 8. International Transfers

Data may be transferred to and processed in countries outside your residence. We ensure appropriate safeguards are implemented for these transfers.

## 9. Policy Updates

We may update this policy periodically. Material changes will be notified through the App or via email.

## 10. Contact Information

For privacy concerns or data requests:
- Developer: {$inputs['developer_name']}
- Website: {$inputs['website_url']}
- Email: {$inputs['contact_email']}

EOD;
}
?>
<!-- Improved responsive design and UI enhancements (without dark mode) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Store Privacy Policy Generator | Compliance Tool</title>
    <meta name="description" content="Generate 100% compliant Google Play Store privacy policies with automatic updates for GDPR, CCPA, COPPA, and Play Console requirements.">
    <meta name="keywords" content="play store privacy policy, android app compliance, GDPR policy generator, COPPA compliance, google play console requirements">
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>
    
    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
        }
        .policy-section {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }
        .form-check-input:checked {
            background-color: #6366f1;
            border-color: #6366f1;
        }
        .highlight {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .copy-btn {
            position: absolute;
            right: 1rem;
            top: 1rem;
        }
        /* Responsive improvements */
        @media (max-width: 768px) {
            .data-collection-grid {
                grid-template-columns: 1fr;
            }
            pre {
                font-size: 0.8rem;
            }
            .policy-display {
                max-height: 50vh;
            }
        }
        .card {
            height: 100%;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        /* Accessibility improvements */
        .form-label {
            font-weight: 500;
        }
        .form-text {
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="display-5 fw-bold highlight">Play Store Privacy Policy Generator</h1>
        <p class="lead">Create fully compliant privacy policies for Google Play Store submissions</p>
    </div>

    <div class="row g-4">
        <!-- Form Column -->
        <div class="col-lg-7">
            <form method="POST" class="policy-section p-4 shadow">
                <div class="row g-3">
                    <!-- Basic Info Section with indicators -->
                    <div class="col-12 mb-2">
                        <h5><i class="bi bi-info-circle"></i> Basic Information</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label" for="app_name"><i class="bi bi-app"></i> App Name *</label>
                        <input type="text" id="app_name" name="app_name" class="form-control" required aria-describedby="appNameHelp">
                        <div id="appNameHelp" class="form-text">Exactly as it appears on Play Store</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="developer_name"><i class="bi bi-person-badge"></i> Developer Name *</label>
                        <input type="text" id="developer_name" name="developer_name" class="form-control" required aria-describedby="devNameHelp">
                        <div id="devNameHelp" class="form-text">Company or individual name</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label" for="contact_email"><i class="bi bi-envelope"></i> Contact Email *</label>
                        <input type="email" id="contact_email" name="contact_email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="website_url"><i class="bi bi-globe"></i> Website URL *</label>
                        <input type="url" id="website_url" name="website_url" class="form-control" placeholder="https://example.com" required>
                    </div>
                    
                    <!-- Country selection with datalist for faster input -->
                    <!--<div class="col-md-6">-->
                    <!--    <label class="form-label" for="country"><i class="bi bi-geo-alt"></i> Primary User Country</label>-->
                    <!--    <input type="text" id="country" name="country" class="form-control" list="country-list" placeholder="Select or type...">-->
                    <!--    <datalist id="country-list">-->
                    <!--        <option value="United States">-->
                    <!--        <option value="European Union">-->
                    <!--        <option value="United Kingdom">-->
                    <!--        <option value="Canada">-->
                    <!--        <option value="Australia">-->
                    <!--        <option value="India">-->
                    <!--        <option value="Brazil">-->
                    <!--        <option value="Global">-->
                    <!--    </datalist>-->
                    <!--</div>-->
                    
                    <!-- Enhanced Data Collection Section -->
                    <div class="col-12 mt-4">
                        <h5><i class="bi bi-database"></i> Data Collection (required by Data Safety Section)</h5>
                        <p class="small text-muted mb-3">Select all data types your app collects</p>
                        
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 data-collection-grid">
                            <?php 
                            $dataOptions = [
                                'Personal Identifiers' => ['Name', 'Email', 'Phone Number'],
                                'Financial Data' => ['Payment Information', 'Transaction History'],
                                'Location Data' => ['GPS Data', 'IP Address'],
                                'Usage Data' => ['App Crashes', 'Feature Usage'],
                                'Device Information' => ['Model', 'OS Version', 'Unique Identifiers'],
                                'User Content' => ['Messages', 'Uploaded Files']
                            ];
                            foreach ($dataOptions as $category => $items): ?>
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header fw-bold small"><?= $category ?></div>
                                    <div class="card-body">
                                        <?php foreach ($items as $item): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="data_types[]" id="data_<?= str_replace(' ', '_', $item) ?>" value="<?= $item ?>">
                                            <label class="form-check-label small" for="data_<?= str_replace(' ', '_', $item) ?>"><?= $item ?></label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Advanced Policy Options -->
                    <div class="col-12 mt-4">
                        <h5><i class="bi bi-shield-check"></i> Compliance Features</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="data_retention">Data Retention Period</label>
                                <input type="text" id="data_retention" name="data_retention" class="form-control" value="30 days" aria-describedby="retentionHelp">
                                <div id="retentionHelp" class="form-text">How long you keep user data</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="third_party_services">Third-party Services</label>
                                <input type="text" id="third_party_services" name="third_party_services" class="form-control" placeholder="Google Analytics, Firebase, etc." aria-describedby="thirdPartyHelp">
                                <div id="thirdPartyHelp" class="form-text">Comma-separated list</div>
                            </div>
                            
                            <!-- Important compliance checkboxes -->
                            <div class="col-12">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="coppa_compliant" name="coppa_compliant">
                                            <label class="form-check-label" for="coppa_compliant">
                                                <strong>COPPA Compliant</strong> - This app is intended for children under 13
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="data_deletion" name="data_deletion" checked>
                                            <label class="form-check-label" for="data_deletion">
                                                <strong>Data Deletion Requests</strong> - Required for Play Store compliance
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label" for="security_practices">Security Practices</label>
                                <select class="form-select" id="security_practices" name="security_practices[]" multiple size="4" aria-describedby="securityHelp">
                                    <option value="SSL/TLS Encryption">SSL/TLS Encryption</option>
                                    <option value="Two-Factor Authentication">Two-Factor Authentication</option>
                                    <option value="Regular Security Audits">Regular Security Audits</option>
                                    <option value="Data Anonymization">Data Anonymization</option>
                                    <option value="Secure Data Storage">Secure Data Storage</option>
                                    <option value="Access Controls">Access Controls</option>
                                </select>
                                <div id="securityHelp" class="form-text">Hold Ctrl/Cmd to select multiple</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4 py-2">
                            <i class="bi bi-file-earmark-text"></i> Generate Policy
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Policy Display Column -->
        <?php if (!empty($policy_content)): ?>
        <div class="col-lg-5">
            <div class="policy-section p-4 shadow position-sticky" style="top: 2rem;">
                <h5 class="mb-3"><i class="bi bi-file-text"></i> Your Privacy Policy</h5>
                <!-- Action Buttons -->
                <div class="d-flex gap-2 mb-3">
                    <button onclick="copyPolicy()" class="btn btn-success btn-sm">
                        <i class="bi bi-clipboard"></i> Copy
                    </button>
                    <button onclick="downloadPolicy()" class="btn btn-primary btn-sm">
                        <i class="bi bi-download"></i> Download
                    </button>
                    <button onclick="previewPolicy()" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> Preview
                    </button>
                </div>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>Ready for Google Play Data Safety Section</div>
                </div>
                <pre id="policyContent" class="bg-light p-3 rounded overflow-auto policy-display" style="max-height: 65vh; font-size: 0.9rem;"><?= $policy_content ?></pre>
            </div>
        </div>
        <?php else: ?>
        <div class="col-lg-5">
            <div class="policy-section p-4 shadow d-flex flex-column justify-content-center align-items-center" style="min-height: 300px;">
                <i class="bi bi-file-earmark-text display-1 text-muted mb-3"></i>
                <h4 class="text-center">Your privacy policy will appear here</h4>
                <p class="text-center text-muted">Fill out the form and click "Generate Policy"</p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Enhanced Features & Compliance Section -->
    <section class="mt-5 policy-section p-4 shadow">
        <h2 class="h4 mb-4 highlight">Play Store Compliance Made Simple</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 h-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="h5"><i class="bi bi-google text-primary"></i> Google Play Requirements Covered</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Data Safety Section Compliance
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> GDPR Right to Erasure
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> COPPA Children's Privacy
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> CCPA Consumer Rights
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 h-100 shadow-sm">
                    <div class="card-body">
                        <h3 class="h5"><i class="bi bi-shield-lock text-primary"></i> Automatic Policy Features</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Automatic Date Stamping
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Third-party Service Disclosure
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Data Retention Configuration
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Data Deletion Mechanisms
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Responsive footer -->
    <footer class="mt-5 text-center text-muted">
        <p class="small">This tool helps create privacy policies for Google Play Store submissions</p>
        <p class="small">Not affiliated with Google LLC</p>
    </footer>
</div>

<!-- Modal for policy preview -->
<div class="modal fade" id="policyPreviewModal" tabindex="-1" aria-labelledby="policyPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="policyPreviewModalLabel">Preview Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="policyPreviewContent">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="copyPolicy()">Copy to Clipboard</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Enhanced copy function with better feedback
function copyPolicy() {
    const content = document.getElementById('policyContent').innerText;
    navigator.clipboard.writeText(content).then(() => {
        showAlert('Policy copied to clipboard!', 'success');
    }).catch(err => {
        showAlert('Failed to copy. Try selecting and copying manually.', 'danger');
    });
}

// Enhanced download function with better naming
function downloadPolicy() {
    const content = document.getElementById('policyContent').innerText;
    const appName = document.getElementById('app_name').value || 'app';
    const sanitizedAppName = appName.replace(/[^a-z0-9]/gi, '-').toLowerCase();
    const blob = new Blob([content], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${sanitizedAppName}-privacy-policy.md`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    showAlert('Privacy policy downloaded!', 'success');
}

// New preview function for better readability
function previewPolicy() {
    const content = document.getElementById('policyContent').innerText;
    const previewContent = document.getElementById('policyPreviewContent');
    
    // Convert markdown to HTML (simple version)
    let htmlContent = content
        .replace(/^# (.*$)/gm, '<h1>$1</h1>')
        .replace(/^## (.*$)/gm, '<h2>$1</h2>')
        .replace(/^### (.*$)/gm, '<h3>$1</h3>')
        .replace(/\*\*(.*)\*\*/gm, '<strong>$1</strong>')
        .replace(/\*(.*)\*/gm, '<em>$1</em>')
        .replace(/\n- (.*)/gm, '<ul><li>$1</li></ul>')
        .replace(/<\/ul><ul>/gm, '')
        .replace(/\n/gm, '<br>');
    
    previewContent.innerHTML = htmlContent;
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('policyPreviewModal'));
    modal.show();
}

// Improved alert function
function showAlert(message, type = 'success') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alertDiv.setAttribute('role', 'alert');
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alertDiv);
        bsAlert.close();
    }, 3000);
}

// Enhanced form validation
document.querySelectorAll('input, select').forEach(element => {
    element.addEventListener('input', () => {
        if (element.checkValidity()) {
            element.classList.remove('is-invalid');
            element.classList.add('is-valid');
        } else {
            element.classList.remove('is-valid');
        }
    });
});

// Form submission validation
document.querySelector('form').addEventListener('submit', (e) => {
    let isValid = true;
    document.querySelectorAll('[required]').forEach(element => {
        if (!element.value.trim()) {
            element.classList.add('is-invalid');
            isValid = false;
        } else {
            element.classList.add('is-valid');
        }
    });
    
    if (document.querySelectorAll('[name="data_types[]"]:checked').length === 0) {
        showAlert('Please select at least one data collection type', 'warning');
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
        showAlert('Please fill all required fields', 'danger');
        // Scroll to first error
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});
</script>
</body>
</html>
<?php include("../footer.php")?>