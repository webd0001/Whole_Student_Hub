<?php
require_once __DIR__ . '/config/config.php';

$serviceId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$serviceId) {
    redirect('services.php');
}

$db = Database::getInstance()->getConnection();

// Get service details
$stmt = $db->prepare("
    SELECT s.*, u.name as staff_name, u.email as staff_email, u.bio as staff_bio 
    FROM services s 
    LEFT JOIN users u ON s.assigned_staff_id = u.id 
    WHERE s.id = ? AND s.is_active = 1
");
$stmt->execute([$serviceId]);
$service = $stmt->fetch();

if (!$service) {
    redirect('services.php');
}

// Get related services
$stmt = $db->prepare("
    SELECT * FROM services 
    WHERE category = ? AND id != ? AND is_active = 1 
    LIMIT 3
");
$stmt->execute([$service['category'], $serviceId]);
$relatedServices = $stmt->fetchAll();

$pageTitle = $service['title'] . ' - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    .service-detail-header {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
    
    .detail-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: rgba(0,0,0,0.02);
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2196f3, #1976d2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .staff-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        text-align: center;
    }
    
    .staff-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1976d2, #1565c0);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        font-weight: 600;
        margin: 0 auto 1rem;
    }
    
    .related-service-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .related-service-card:hover {
        transform: translateY(-4px);
    }
</style>

<!-- Header -->
<div class="service-detail-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-white">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>services.php" class="text-white">Services</a></li>
                <li class="breadcrumb-item active text-white"><?php echo htmlspecialchars($service['title']); ?></li>
            </ol>
        </nav>
        <h1 class="fw-bold mb-2"><?php echo htmlspecialchars($service['title']); ?></h1>
        <p class="mb-0 opacity-90">
            <span class="badge bg-light text-dark me-2"><?php echo ucfirst($service['category']); ?></span>
            <span class="badge bg-light text-dark"><?php echo ucfirst($service['mode']); ?></span>
        </p>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Service Description -->
            <div class="detail-card">
                <h4 class="fw-bold mb-3">About This Service</h4>
                <p class="text-muted"><?php echo nl2br(htmlspecialchars($service['description'])); ?></p>
            </div>
            
            <!-- Service Details -->
            <div class="detail-card">
                <h4 class="fw-bold mb-3">Service Details</h4>
                
                <div class="info-item">
                    <div class="info-icon">
                        <span class="material-icons">schedule</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Duration</h6>
                        <p class="text-muted mb-0"><?php echo $service['duration_minutes']; ?> minutes per session</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <span class="material-icons">location_on</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Mode</h6>
                        <p class="text-muted mb-0">
                            <?php 
                            if ($service['mode'] === 'both') {
                                echo 'Available both Online and In-Person';
                            } else {
                                echo ucfirst($service['mode']);
                            }
                            ?>
                        </p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <span class="material-icons">category</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Category</h6>
                        <p class="text-muted mb-0"><?php echo ucfirst($service['category']); ?></p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <span class="material-icons">priority_high</span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Urgency Level</h6>
                        <p class="text-muted mb-0"><?php echo ucfirst($service['urgency_level']); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- What to Expect -->
            <div class="detail-card">
                <h4 class="fw-bold mb-3">What to Expect</h4>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <span class="material-icons text-success" style="vertical-align: middle;">check_circle</span>
                        Professional and confidential support
                    </li>
                    <li class="mb-2">
                        <span class="material-icons text-success" style="vertical-align: middle;">check_circle</span>
                        Personalized guidance tailored to your needs
                    </li>
                    <li class="mb-2">
                        <span class="material-icons text-success" style="vertical-align: middle;">check_circle</span>
                        Flexible scheduling options
                    </li>
                    <li class="mb-2">
                        <span class="material-icons text-success" style="vertical-align: middle;">check_circle</span>
                        Follow-up resources and materials
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Book Appointment Card -->
            <div class="detail-card sticky-top" style="top: 20px;">
                <h5 class="fw-bold mb-3">Ready to Get Started?</h5>
                <p class="text-muted mb-3">Book an appointment and take the first step towards your goals.</p>
                
                <?php if (isLoggedIn()): ?>
                    <a href="<?php echo BASE_URL; ?>book-appointment.php?service=<?php echo $service['id']; ?>" class="btn btn-primary btn-lg w-100 mb-2">
                        <span class="material-icons" style="vertical-align: middle;">event</span>
                        Book Appointment
                    </a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>auth/login.php" class="btn btn-primary btn-lg w-100 mb-2">
                        <span class="material-icons" style="vertical-align: middle;">login</span>
                        Login to Book
                    </a>
                    <p class="text-center text-muted mb-0">
                        <small>Don't have an account? <a href="<?php echo BASE_URL; ?>auth/signup.php">Sign up</a></small>
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- Staff Information -->
            <?php if ($service['staff_name']): ?>
                <div class="staff-card mt-3">
                    <div class="staff-avatar">
                        <?php echo strtoupper(substr($service['staff_name'], 0, 2)); ?>
                    </div>
                    <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($service['staff_name']); ?></h5>
                    <p class="text-muted mb-2">Service Provider</p>
                    <?php if ($service['staff_bio']): ?>
                        <p class="text-muted small"><?php echo htmlspecialchars($service['staff_bio']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Related Services -->
    <?php if (!empty($relatedServices)): ?>
        <div class="mt-5">
            <h4 class="fw-bold mb-4">Related Services</h4>
            <div class="row g-4">
                <?php foreach ($relatedServices as $related): ?>
                    <div class="col-md-4">
                        <div class="related-service-card">
                            <h6 class="fw-bold mb-2"><?php echo htmlspecialchars($related['title']); ?></h6>
                            <p class="text-muted small mb-3">
                                <?php echo htmlspecialchars(substr($related['description'], 0, 100)) . '...'; ?>
                            </p>
                            <a href="service-detail.php?id=<?php echo $related['id']; ?>" class="btn btn-sm btn-outline-primary w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
