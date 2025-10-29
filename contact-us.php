<?php
// Set page title and description
$pageTitle = 'Contact Us';
$pageDescription = 'Get in touch with the ToolHub team for questions, feedback, or support.';


// Initialize variables for form data and errors
$name = $email = $subject = $message = '';
$nameErr = $emailErr = $subjectErr = $messageErr = $captchaErr = '';
$formSubmitted = false;
$formSuccess = false;
$spamDetected = false;

// Generate CAPTCHA code
session_start();
if (!isset($_SESSION['captcha'])) {
    $_SESSION['captcha'] = generateCaptchaCode();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check honeypot field (anti-spam)
    if (!empty($_POST["website"])) {
        // This is a bot as humans won't see and fill this field
        $spamDetected = true;
    } else {
        // Check submission time (anti-spam)
        $submissionTime = time();
        if (isset($_SESSION['form_rendered_time']) && ($submissionTime - $_SESSION['form_rendered_time'] < 3)) {
            // Form submitted too quickly (less than 3 seconds) - likely a bot
            $spamDetected = true;
        } else {
            // Validate CAPTCHA
            if (empty($_POST["captcha"])) {
                $captchaErr = "Please enter the security code";
            } else {
                $userCaptcha = test_input($_POST["captcha"]);
                if ($userCaptcha != $_SESSION['captcha']) {
                    $captchaErr = "Security code doesn't match";
                }
            }
            
            // Validate name
            if (empty($_POST["name"])) {
                $nameErr = "Name is required";
            } else {
                $name = test_input($_POST["name"]);
            }
            
            // Validate email
            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
            } else {
                $email = test_input($_POST["email"]);
                // Check if email address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                }
            }
            
            // Validate subject
            if (empty($_POST["subject"])) {
                $subjectErr = "Subject is required";
            } else {
                $subject = test_input($_POST["subject"]);
            }
            
            // Validate message
            if (empty($_POST["message"])) {
                $messageErr = "Message is required";
            } else {
                $message = test_input($_POST["message"]);
                
                // Check for spam keywords in message (anti-spam)
                $spamKeywords = array("viagra", "casino", "lottery", "winner", "buy now", "free offer", "make money fast");
                foreach ($spamKeywords as $keyword) {
                    if (stripos($message, $keyword) !== false) {
                        $spamDetected = true;
                        break;
                    }
                }
                
                // Check for too many URLs in message (anti-spam)
                $urlCount = substr_count(strtolower($message), "http://") + substr_count(strtolower($message), "https://");
                if ($urlCount > 3) {
                    $spamDetected = true;
                }
            }
            
            // If no errors and no spam detected, proceed with sending the email
            if (empty($nameErr) && empty($emailErr) && empty($subjectErr) && empty($messageErr) && empty($captchaErr) && !$spamDetected) {
                $formSubmitted = true;
                
                // Email recipient
                $to = "contact@infinitytoolspace.com";
                
                // Email headers
                $headers = "From: noreply@infinitytoolspace.com" . "\r\n" .
                           "Reply-To: $email" . "\r\n" .
                           "X-Mailer: PHP/" . phpversion();
                
                // Email content
                $emailContent = "Name: $name\n";
                $emailContent .= "Email: $email\n\n";
                $emailContent .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
                $emailContent .= "User Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\n\n";
                $emailContent .= "Message:\n$message";
                
                // Attempt to send email
                if (mail($to, $subject, $emailContent, $headers)) {
                    $formSuccess = true;
                    
                    // Reset form data after successful submission
                    $name = $email = $subject = $message = '';
                    
                    // Generate new CAPTCHA
                    $_SESSION['captcha'] = generateCaptchaCode();
                }
            }
        }
    }
}

// Function to sanitize form data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to generate CAPTCHA code
function generateCaptchaCode($length = 6) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $captchaCode = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $captchaCode .= $characters[mt_rand(0, $max)];
    }
    return $captchaCode;
}

// Set form rendered time for timing check
$_SESSION['form_rendered_time'] = time();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <h1 class="text-center mb-4">Contact Us</h1>
                    <p class="text-center mb-5">Have questions, feedback, or need help with our tools? We'd love to hear from you!</p>
                    
                    <?php if ($formSubmitted && $formSuccess): ?>
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Thank you for your message!</h4>
                        <p>We have received your inquiry and will get back to you as soon as possible.</p>
                    </div>
                    <?php elseif ($formSubmitted): ?>
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Oops!</h4>
                        <p>Something went wrong while sending your message. Please try again or email us directly at contact@infinitytoolspace.com.</p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!$formSubmitted || !$formSuccess): ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" class="form-control <?php echo (!empty($nameErr)) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo $name; ?>" placeholder="John Doe" required>
                                <div class="invalid-feedback">
                                    <?php echo !empty($nameErr) ? $nameErr : 'Please provide your name.'; ?>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Your Email</label>
                                <input type="email" class="form-control <?php echo (!empty($emailErr)) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $email; ?>" placeholder="john@example.com" required>
                                <div class="invalid-feedback">
                                    <?php echo !empty($emailErr) ? $emailErr : 'Please provide a valid email address.'; ?>
                                </div>
                            </div>
                            <!-- Honeypot field for spam protection - hidden from real users -->
                            <div class="d-none">
                                <label for="website">Website</label>
                                <input type="text" id="website" name="website" autocomplete="off">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control <?php echo (!empty($subjectErr)) ? 'is-invalid' : ''; ?>" id="subject" name="subject" value="<?php echo $subject; ?>" placeholder="How can we help you?" required>
                                <div class="invalid-feedback">
                                    <?php echo !empty($subjectErr) ? $subjectErr : 'Please provide a subject.'; ?>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control <?php echo (!empty($messageErr)) ? 'is-invalid' : ''; ?>" id="message" name="message" rows="5" placeholder="Your message here..." required><?php echo $message; ?></textarea>
                                <div class="invalid-feedback">
                                    <?php echo !empty($messageErr) ? $messageErr : 'Please provide a message.'; ?>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <label for="captcha" class="form-label">Security Check</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <strong><?php echo $_SESSION['captcha']; ?></strong>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control <?php echo (!empty($captchaErr)) ? 'is-invalid' : ''; ?>" id="captcha" name="captcha" placeholder="Enter the code shown" required>
                                    <div class="invalid-feedback">
                                        <?php echo !empty($captchaErr) ? $captchaErr : 'Please enter the security code.'; ?>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Enter the code exactly as shown above</small>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary px-5">Send Message</button>
                            </div>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mt-5">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm text-center p-4">
                            <div class="card-body">
                                <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                                <h5>Email Us</h5>
                                <p class="mb-0">contact@infinitytoolspace.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm text-center p-4">
                            <div class="card-body">
                                <i class="fas fa-map-marker-alt fa-2x text-primary mb-3"></i>
                                <h5>Visit Us</h5>
                                <p class="mb-0">Indirapuram, Ghaziabad<br>Uttar Pradesh, IN</p>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-md-4">-->
                    <!--    <div class="card h-100 border-0 shadow-sm text-center p-4">-->
                    <!--        <div class="card-body">-->
                    <!--            <i class="fas fa-map-marker-alt fa-2x text-primary mb-3"></i>-->
                    <!--            <h5>Visit Us</h5>-->
                    <!--            <p class="mb-0">Indirapuram, Ghaziabad<br>Uttar Pradesh, IN</p>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation with Bootstrap
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

<?php
// Include footer
include 'footer.php';
?>