<?php
require_once __DIR__ . '/config/config.php';
requireLogin();

$user = getCurrentUser();
$db = Database::getInstance()->getConnection();

$error = '';
$success = '';

// Get service ID from URL if provided
$preselectedService = isset($_GET['service']) ? (int)$_GET['service'] : 0;

// Get all active services
$stmt = $db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY category, title");
$services = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceId = (int)$_POST['service_id'];
    $category = sanitize($_POST['category']);
    $mode = sanitize($_POST['mode']);
    $description = sanitize($_POST['description']);
    $appointmentDate = sanitize($_POST['appointment_date']);
    $appointmentTime = sanitize($_POST['appointment_time']);
    
    // Handle file upload
    $documentPath = null;
    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadFile($_FILES['document'], 'appointments');
        if ($uploadResult['success']) {
            $documentPath = $uploadResult['path'];
        } else {
            $error = $uploadResult['message'];
        }
    }
    
    if (empty($error)) {
        if (empty($serviceId) || empty($category) || empty($mode) || empty($description)) {
            $error = 'Please fill in all required fields';
        } else {
            // Insert appointment
            $stmt = $db->prepare("
                INSERT INTO appointments (student_id, service_id, category, mode, description, document_path, appointment_date, appointment_time) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            if ($stmt->execute([$user['id'], $serviceId, $category, $mode, $description, $documentPath, $appointmentDate ?: null, $appointmentTime ?: null])) {
                $success = 'Appointment request submitted successfully! We will contact you soon.';
                // Redirect after 2 seconds
                header("refresh:2;url=" . BASE_URL . "appointments.php");
            } else {
                $error = 'Failed to submit appointment request. Please try again.';
            }
        }
    }
}

$pageTitle = 'Book Appointment - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    .booking-header {
        background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
    
    .booking-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }
</style>

<!-- Header -->
<div class="booking-header">
    <div class="container">
        <h1 class="fw-bold mb-2">Book an Appointment</h1>
        <p class="mb-0 opacity-90">Fill out the form below to request support</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="booking-card">
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
                
                <form method="POST" action="" enctype="multipart/form-data">
                    <!-- Service Selection -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <span class="material-icons" style="vertical-align: middle;">medical_services</span>
                            Select Service
                        </h5>
                        
                        <select class="form-select" name="service_id" required>
                            <option value="">Choose a service...</option>
                            <?php 
                            $currentCategory = '';
                            foreach ($services as $service): 
                                if ($currentCategory !== $service['category']) {
                                    if ($currentCategory !== '') echo '</optgroup>';
                                    echo '<optgroup label="' . ucfirst($service['category']) . '">';
                                    $currentCategory = $service['category'];
                                }
                            ?>
                                <option value="<?php echo $service['id']; ?>" <?php echo $preselectedService == $service['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($service['title']); ?>
                                </option>
                            <?php endforeach; ?>
                            <?php if ($currentCategory !== '') echo '</optgroup>'; ?>
                        </select>
                    </div>
                    
                    <!-- Request Details -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <span class="material-icons" style="vertical-align: middle;">info</span>
                            Request Details
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select class="form-select" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="academic">Academic</option>
                                    <option value="emotional">Emotional/Mental Health</option>
                                    <option value="career">Career</option>
                                    <option value="mentorship">Mentorship</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <select class="form-select" name="mode" required>
                                    <option value="">Select Mode</option>
                                    <option value="online">Online</option>
                                    <option value="in-person">In-Person</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-outline mb-3">
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                            <label class="form-label" for="description">Describe your request or concern</label>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Upload Document (Optional)</label>
                            <input type="file" class="form-control" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
                            <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max 5MB)</small>
                        </div>
                    </div>
                    
                    <!-- Preferred Date & Time -->
                    <div class="form-section">
                        <h5 class="section-title">
                            <span class="material-icons" style="vertical-align: middle;">event</span>
                            Preferred Date & Time (Optional)
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-outline">
                                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" />
                                    <label class="form-label" for="appointment_date">Preferred Date</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-outline">
                                    <input type="time" class="form-control" id="appointment_time" name="appointment_time" />
                                    <label class="form-label" for="appointment_time">Preferred Time</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <span class="material-icons" style="vertical-align: middle;">info</span>
                            Your preferred date and time are suggestions. The final appointment will be confirmed by our staff.
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <span class="material-icons" style="vertical-align: middle;">send</span>
                            Submit Request
                        </button>
                        <a href="<?php echo BASE_URL; ?>services.php" class="btn btn-outline-secondary">
                            <span class="material-icons" style="vertical-align: middle;">arrow_back</span>
                            Back to Services
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
