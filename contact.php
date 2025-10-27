<?php
require_once __DIR__ . '/config/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } else {
        // In a real application, send email here
        // For now, we'll just show success message
        $success = 'Thank you for contacting us! We will get back to you soon.';
    }
}

$pageTitle = 'Contact Us - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    .contact-header {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
    
    .contact-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        height: 100%;
    }
    
    .contact-info-item {
        display: flex;
        align-items: start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .contact-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2196f3, #1976d2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
</style>

<!-- Header -->
<div class="contact-header">
    <div class="container">
        <h1 class="fw-bold mb-2">Contact Us</h1>
        <p class="mb-0 opacity-90">We're here to help and answer any questions you might have</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="contact-card">
                <h4 class="fw-bold mb-4">Send us a Message</h4>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="material-icons" style="vertical-align: middle; font-size: 20px;">error</span>
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="material-icons" style="vertical-align: middle; font-size: 20px;">check_circle</span>
                        <?php echo $success; ?>
                        <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-outline">
                                <input type="text" id="name" name="name" class="form-control" required />
                                <label class="form-label" for="name">Your Name</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-outline">
                                <input type="email" id="email" name="email" class="form-control" required />
                                <label class="form-label" for="email">Your Email</label>
                            </div>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <div class="form-outline">
                                <input type="text" id="subject" name="subject" class="form-control" required />
                                <label class="form-label" for="subject">Subject</label>
                            </div>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <div class="form-outline">
                                <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                                <label class="form-label" for="message">Message</label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg">
                        <span class="material-icons" style="vertical-align: middle;">send</span>
                        Send Message
                    </button>
                </form>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="contact-card">
                <h4 class="fw-bold mb-4">Contact Information</h4>
                
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <span class="material-icons">location_on</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Address</h6>
                        <p class="text-muted mb-0">Campus Student Center<br>University Campus<br>City, State 12345</p>
                    </div>
                </div>
                
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <span class="material-icons">email</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Email</h6>
                        <p class="text-muted mb-0">support@wholestudent.com</p>
                    </div>
                </div>
                
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <span class="material-icons">phone</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Phone</h6>
                        <p class="text-muted mb-0">+91 123 456 7890</p>
                    </div>
                </div>
                
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <span class="material-icons">schedule</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Office Hours</h6>
                        <p class="text-muted mb-0">Monday - Friday<br>9:00 AM - 5:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
