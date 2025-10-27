<?php
require_once __DIR__ . '/../config/config.php';
requireRole(['admin', 'counselor', 'mentor']);

$user = getCurrentUser();
$db = Database::getInstance()->getConnection();

// Get statistics
$stats = [];

// Total users
$stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'student'");
$stats['students'] = $stmt->fetch()['count'];

// Total appointments
$stmt = $db->query("SELECT COUNT(*) as count FROM appointments");
$stats['total_appointments'] = $stmt->fetch()['count'];

// Pending appointments
$stmt = $db->query("SELECT COUNT(*) as count FROM appointments WHERE status = 'pending'");
$stats['pending_appointments'] = $stmt->fetch()['count'];

// Completed appointments
$stmt = $db->query("SELECT COUNT(*) as count FROM appointments WHERE status = 'completed'");
$stats['completed_appointments'] = $stmt->fetch()['count'];

// Total services
$stmt = $db->query("SELECT COUNT(*) as count FROM services WHERE is_active = 1");
$stats['services'] = $stmt->fetch()['count'];

// Total resources
$stmt = $db->query("SELECT COUNT(*) as count FROM resources WHERE is_active = 1");
$stats['resources'] = $stmt->fetch()['count'];

// Recent appointments
$stmt = $db->prepare("
    SELECT a.*, s.title as service_title, u1.name as student_name, u2.name as staff_name 
    FROM appointments a 
    LEFT JOIN services s ON a.service_id = s.id 
    LEFT JOIN users u1 ON a.student_id = u1.id 
    LEFT JOIN users u2 ON a.staff_id = u2.id 
    ORDER BY a.created_at DESC 
    LIMIT 10
");
$stmt->execute();
$recentAppointments = $stmt->fetchAll();

$pageTitle = 'Admin Dashboard - Whole Student Hub';
include __DIR__ . '/header.php';
?>

<div class="container-fluid py-4">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="fw-bold mb-2">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h4>
                    <p class="text-muted mb-0">Here's an overview of the platform activity</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Students</p>
                            <h3 class="fw-bold mb-0"><?php echo $stats['students']; ?></h3>
                        </div>
                        <div class="stat-icon bg-primary">
                            <span class="material-icons">people</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Pending Requests</p>
                            <h3 class="fw-bold mb-0"><?php echo $stats['pending_appointments']; ?></h3>
                        </div>
                        <div class="stat-icon bg-warning">
                            <span class="material-icons">pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Completed Sessions</p>
                            <h3 class="fw-bold mb-0"><?php echo $stats['completed_appointments']; ?></h3>
                        </div>
                        <div class="stat-icon bg-success">
                            <span class="material-icons">check_circle</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Active Services</p>
                            <h3 class="fw-bold mb-0"><?php echo $stats['services']; ?></h3>
                        </div>
                        <div class="stat-icon bg-info">
                            <span class="material-icons">medical_services</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Appointments -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Recent Appointments</h5>
                    <a href="appointments.php" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Service</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recentAppointments)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No appointments yet</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($recentAppointments as $appointment): ?>
                                        <tr>
                                            <td>#<?php echo $appointment['id']; ?></td>
                                            <td><?php echo htmlspecialchars($appointment['student_name']); ?></td>
                                            <td><?php echo htmlspecialchars($appointment['service_title']); ?></td>
                                            <td><span class="badge bg-secondary"><?php echo ucfirst($appointment['category']); ?></span></td>
                                            <td>
                                                <span class="badge bg-<?php echo getStatusBadgeClass($appointment['status']); ?>">
                                                    <?php echo ucfirst($appointment['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo formatDateTime($appointment['created_at']); ?></td>
                                            <td>
                                                <a href="appointment-detail.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <span class="material-icons" style="font-size: 16px;">visibility</span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card {
        border: none;
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
        color: white;
    }
    
    .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 12px;
    }
    
    .card-header {
        background: var(--card-bg);
        border-bottom: 1px solid rgba(0,0,0,0.1);
        padding: 1rem 1.5rem;
    }
</style>

<?php include __DIR__ . '/footer.php'; ?>
