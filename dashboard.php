<?php
require_once __DIR__ . '/config/config.php';
requireLogin();

$user = getCurrentUser();
$db = Database::getInstance()->getConnection();

// Get user statistics
$stmt = $db->prepare("SELECT COUNT(*) as total FROM appointments WHERE student_id = ?");
$stmt->execute([$user['id']]);
$totalAppointments = $stmt->fetch()['total'];

$stmt = $db->prepare("SELECT COUNT(*) as total FROM appointments WHERE student_id = ? AND status = 'pending'");
$stmt->execute([$user['id']]);
$pendingAppointments = $stmt->fetch()['total'];

$stmt = $db->prepare("SELECT COUNT(*) as total FROM appointments WHERE student_id = ? AND status = 'completed'");
$stmt->execute([$user['id']]);
$completedAppointments = $stmt->fetch()['total'];

// Get recent appointments
$stmt = $db->prepare("
    SELECT a.*, s.title as service_title, s.category, u.name as staff_name 
    FROM appointments a 
    LEFT JOIN services s ON a.service_id = s.id 
    LEFT JOIN users u ON a.staff_id = u.id 
    WHERE a.student_id = ? 
    ORDER BY a.created_at DESC 
    LIMIT 5
");
$stmt->execute([$user['id']]);
$recentAppointments = $stmt->fetchAll();

// Get available services count
$stmt = $db->query("SELECT COUNT(*) as total FROM services WHERE is_active = 1");
$totalServices = $stmt->fetch()['total'];

$pageTitle = 'Dashboard - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    .dashboard-container {
        padding: 2rem 0;
        min-height: calc(100vh - 300px);
    }
    
    .welcome-card {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        color: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin-bottom: 1rem;
    }
    
    .stat-icon.primary {
        background: linear-gradient(135deg, #2196f3, #1976d2);
        color: white;
    }
    
    .stat-icon.warning {
        background: linear-gradient(135deg, #ff9800, #f57c00);
        color: white;
    }
    
    .stat-icon.success {
        background: linear-gradient(135deg, #4caf50, #2e7d32);
        color: white;
    }
    
    .stat-icon.info {
        background: linear-gradient(135deg, #00bcd4, #0097a7);
        color: white;
    }
    
    .quick-action-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: var(--text-primary);
        display: block;
        height: 100%;
    }
    
    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        color: var(--text-primary);
    }
    
    .action-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 35px;
    }
    
    .appointment-item {
        background: var(--card-bg);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid var(--primary-color);
        transition: transform 0.3s ease;
    }
    
    .appointment-item:hover {
        transform: translateX(4px);
    }
</style>

<div class="dashboard-container">
    <div class="container">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-2">
                        Welcome back, <?php echo htmlspecialchars($user['name']); ?>! 👋
                    </h2>
                    <p class="mb-0 opacity-90">
                        <?php 
                        $hour = date('H');
                        if ($hour < 12) echo "Good morning!";
                        elseif ($hour < 18) echo "Good afternoon!";
                        else echo "Good evening!";
                        ?>
                        Here's what's happening with your account today.
                    </p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <span class="material-icons" style="font-size: 100px; opacity: 0.3;">dashboard</span>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <span class="material-icons">event</span>
                    </div>
                    <h3 class="fw-bold mb-1"><?php echo $totalAppointments; ?></h3>
                    <p class="text-muted mb-0">Total Appointments</p>
                </div>
            </div>
            
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon warning">
                        <span class="material-icons">pending</span>
                    </div>
                    <h3 class="fw-bold mb-1"><?php echo $pendingAppointments; ?></h3>
                    <p class="text-muted mb-0">Pending</p>
                </div>
            </div>
            
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon success">
                        <span class="material-icons">check_circle</span>
                    </div>
                    <h3 class="fw-bold mb-1"><?php echo $completedAppointments; ?></h3>
                    <p class="text-muted mb-0">Completed</p>
                </div>
            </div>
            
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon info">
                        <span class="material-icons">medical_services</span>
                    </div>
                    <h3 class="fw-bold mb-1"><?php echo $totalServices; ?></h3>
                    <p class="text-muted mb-0">Available Services</p>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <h4 class="fw-bold mb-3">Quick Actions</h4>
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-6">
                <a href="<?php echo BASE_URL; ?>services.php?category=academic" class="quick-action-card">
                    <div class="action-icon" style="background: linear-gradient(135deg, #2196f3, #1976d2); color: white;">
                        <span class="material-icons">school</span>
                    </div>
                    <h6 class="fw-bold">Academic Help</h6>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="<?php echo BASE_URL; ?>services.php?category=counseling" class="quick-action-card">
                    <div class="action-icon" style="background: linear-gradient(135deg, #4caf50, #2e7d32); color: white;">
                        <span class="material-icons">psychology</span>
                    </div>
                    <h6 class="fw-bold">Counseling</h6>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="<?php echo BASE_URL; ?>services.php?category=mentorship" class="quick-action-card">
                    <div class="action-icon" style="background: linear-gradient(135deg, #ff9800, #f57c00); color: white;">
                        <span class="material-icons">groups</span>
                    </div>
                    <h6 class="fw-bold">Mentor Connect</h6>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="<?php echo BASE_URL; ?>services.php?category=career" class="quick-action-card">
                    <div class="action-icon" style="background: linear-gradient(135deg, #9c27b0, #7b1fa2); color: white;">
                        <span class="material-icons">work</span>
                    </div>
                    <h6 class="fw-bold">Career Guidance</h6>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="<?php echo BASE_URL; ?>resources.php" class="quick-action-card">
                    <div class="action-icon" style="background: linear-gradient(135deg, #00bcd4, #0097a7); color: white;">
                        <span class="material-icons">library_books</span>
                    </div>
                    <h6 class="fw-bold">Resources</h6>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="<?php echo BASE_URL; ?>forum.php" class="quick-action-card">
                    <div class="action-icon" style="background: linear-gradient(135deg, #e91e63, #c2185b); color: white;">
                        <span class="material-icons">forum</span>
                    </div>
                    <h6 class="fw-bold">Community</h6>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="<?php echo BASE_URL; ?>support-tickets.php" class="quick-action-card">
                    <div class="action-icon" style="background: linear-gradient(135deg, #607d8b, #455a64); color: white;">
                        <span class="material-icons">support_agent</span>
                    </div>
                    <h6 class="fw-bold">Get Help</h6>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="<?php echo BASE_URL; ?>book-appointment.php" class="quick-action-card">
                    <div class="action-icon" style="background: linear-gradient(135deg, #f44336, #d32f2f); color: white;">
                        <span class="material-icons">add_circle</span>
                    </div>
                    <h6 class="fw-bold">Book Now</h6>
                </a>
            </div>
        </div>
        
        <!-- Recent Appointments -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">Recent Appointments</h4>
                    <a href="<?php echo BASE_URL; ?>appointments.php" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                
                <?php if (empty($recentAppointments)): ?>
                    <div class="text-center py-5">
                        <span class="material-icons" style="font-size: 80px; color: var(--text-secondary); opacity: 0.3;">event_busy</span>
                        <p class="text-muted mt-3">No appointments yet. Book your first session!</p>
                        <a href="<?php echo BASE_URL; ?>book-appointment.php" class="btn btn-primary">
                            <span class="material-icons" style="vertical-align: middle;">add</span>
                            Book Appointment
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($recentAppointments as $appointment): ?>
                        <div class="appointment-item">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($appointment['service_title']); ?></h6>
                                    <p class="text-muted mb-0">
                                        <span class="material-icons" style="vertical-align: middle; font-size: 16px;">category</span>
                                        <?php echo ucfirst($appointment['category']); ?>
                                        <?php if ($appointment['staff_name']): ?>
                                            | <span class="material-icons" style="vertical-align: middle; font-size: 16px;">person</span>
                                            <?php echo htmlspecialchars($appointment['staff_name']); ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">
                                        <span class="material-icons" style="vertical-align: middle; font-size: 16px;">schedule</span>
                                        <?php echo formatDateTime($appointment['created_at']); ?>
                                    </small>
                                </div>
                                <div class="col-md-3 text-end">
                                    <span class="badge bg-<?php echo getStatusBadgeClass($appointment['status']); ?>">
                                        <?php echo ucfirst($appointment['status']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
