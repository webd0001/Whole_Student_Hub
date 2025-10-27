<?php
require_once __DIR__ . '/config/config.php';
requireLogin();

$user = getCurrentUser();
$db = Database::getInstance()->getConnection();

// Handle status filter
$statusFilter = isset($_GET['status']) ? sanitize($_GET['status']) : '';

// Build query
$query = "
    SELECT a.*, s.title as service_title, s.category, u.name as staff_name 
    FROM appointments a 
    LEFT JOIN services s ON a.service_id = s.id 
    LEFT JOIN users u ON a.staff_id = u.id 
    WHERE a.student_id = ?
";
$params = [$user['id']];

if ($statusFilter) {
    $query .= " AND a.status = ?";
    $params[] = $statusFilter;
}

$query .= " ORDER BY a.created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$appointments = $stmt->fetchAll();

// Get counts for each status
$stmt = $db->prepare("SELECT status, COUNT(*) as count FROM appointments WHERE student_id = ? GROUP BY status");
$stmt->execute([$user['id']]);
$statusCounts = [];
while ($row = $stmt->fetch()) {
    $statusCounts[$row['status']] = $row['count'];
}

$pageTitle = 'My Appointments - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    .appointments-header {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
    
    .filter-tabs {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        overflow-x: auto;
        white-space: nowrap;
    }
    
    .filter-tab {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        margin-right: 0.5rem;
        border-radius: 20px;
        text-decoration: none;
        color: var(--text-primary);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .filter-tab:hover {
        background: rgba(25, 118, 210, 0.1);
        color: var(--primary-color);
    }
    
    .filter-tab.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .appointment-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        border-left: 4px solid var(--primary-color);
    }
    
    .appointment-card:hover {
        transform: translateX(4px);
    }
    
    .appointment-card.pending {
        border-left-color: #ff9800;
    }
    
    .appointment-card.accepted {
        border-left-color: #2196f3;
    }
    
    .appointment-card.completed {
        border-left-color: #4caf50;
    }
    
    .appointment-card.cancelled,
    .appointment-card.rejected {
        border-left-color: #f44336;
        opacity: 0.7;
    }
    
    .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
    }
    
    .appointment-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    @media (max-width: 768px) {
        .appointment-header {
            flex-direction: column;
        }
        
        .appointment-actions {
            margin-top: 1rem;
            width: 100%;
        }
        
        .appointment-actions .btn {
            flex: 1;
        }
    }
</style>

<!-- Header -->
<div class="appointments-header">
    <div class="container">
        <h1 class="fw-bold mb-2">My Appointments</h1>
        <p class="mb-0 opacity-90">View and manage your appointment requests</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <a href="?status=" class="filter-tab <?php echo $statusFilter === '' ? 'active' : ''; ?>">
            All (<?php echo array_sum($statusCounts); ?>)
        </a>
        <a href="?status=pending" class="filter-tab <?php echo $statusFilter === 'pending' ? 'active' : ''; ?>">
            Pending (<?php echo $statusCounts['pending'] ?? 0; ?>)
        </a>
        <a href="?status=accepted" class="filter-tab <?php echo $statusFilter === 'accepted' ? 'active' : ''; ?>">
            Accepted (<?php echo $statusCounts['accepted'] ?? 0; ?>)
        </a>
        <a href="?status=ongoing" class="filter-tab <?php echo $statusFilter === 'ongoing' ? 'active' : ''; ?>">
            Ongoing (<?php echo $statusCounts['ongoing'] ?? 0; ?>)
        </a>
        <a href="?status=completed" class="filter-tab <?php echo $statusFilter === 'completed' ? 'active' : ''; ?>">
            Completed (<?php echo $statusCounts['completed'] ?? 0; ?>)
        </a>
        <a href="?status=cancelled" class="filter-tab <?php echo $statusFilter === 'cancelled' ? 'active' : ''; ?>">
            Cancelled (<?php echo $statusCounts['cancelled'] ?? 0; ?>)
        </a>
    </div>
    
    <!-- Appointments List -->
    <?php if (empty($appointments)): ?>
        <div class="text-center py-5">
            <span class="material-icons" style="font-size: 100px; color: var(--text-secondary); opacity: 0.3;">event_busy</span>
            <h4 class="mt-3">No appointments found</h4>
            <p class="text-muted">
                <?php if ($statusFilter): ?>
                    No appointments with status "<?php echo ucfirst($statusFilter); ?>"
                <?php else: ?>
                    You haven't booked any appointments yet
                <?php endif; ?>
            </p>
            <a href="<?php echo BASE_URL; ?>book-appointment.php" class="btn btn-primary">
                <span class="material-icons" style="vertical-align: middle;">add</span>
                Book Your First Appointment
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($appointments as $appointment): ?>
            <div class="appointment-card <?php echo $appointment['status']; ?>">
                <div class="appointment-header">
                    <div>
                        <h5 class="fw-bold mb-2"><?php echo htmlspecialchars($appointment['service_title']); ?></h5>
                        <div class="mb-2">
                            <span class="badge bg-<?php echo getStatusBadgeClass($appointment['status']); ?>">
                                <?php echo ucfirst($appointment['status']); ?>
                            </span>
                            <span class="badge bg-secondary ms-1">
                                <?php echo ucfirst($appointment['category']); ?>
                            </span>
                            <span class="badge bg-info ms-1">
                                <?php echo ucfirst($appointment['mode']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="appointment-actions">
                        <button class="btn btn-sm btn-outline-primary" data-mdb-toggle="modal" data-mdb-target="#detailModal<?php echo $appointment['id']; ?>">
                            <span class="material-icons" style="vertical-align: middle; font-size: 18px;">visibility</span>
                            Details
                        </button>
                        <?php if (in_array($appointment['status'], ['pending', 'accepted'])): ?>
                            <button class="btn btn-sm btn-outline-danger" onclick="cancelAppointment(<?php echo $appointment['id']; ?>)">
                                <span class="material-icons" style="vertical-align: middle; font-size: 18px;">cancel</span>
                                Cancel
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">
                            <span class="material-icons" style="vertical-align: middle; font-size: 18px;">schedule</span>
                            Requested: <?php echo formatDateTime($appointment['created_at']); ?>
                        </p>
                        <?php if ($appointment['appointment_date']): ?>
                            <p class="text-muted mb-1">
                                <span class="material-icons" style="vertical-align: middle; font-size: 18px;">event</span>
                                Scheduled: <?php echo formatDate($appointment['appointment_date']); ?>
                                <?php if ($appointment['appointment_time']): ?>
                                    at <?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <?php if ($appointment['staff_name']): ?>
                            <p class="text-muted mb-1">
                                <span class="material-icons" style="vertical-align: middle; font-size: 18px;">person</span>
                                Assigned to: <?php echo htmlspecialchars($appointment['staff_name']); ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($appointment['meeting_link']): ?>
                            <p class="mb-1">
                                <a href="<?php echo htmlspecialchars($appointment['meeting_link']); ?>" target="_blank" class="text-primary">
                                    <span class="material-icons" style="vertical-align: middle; font-size: 18px;">video_call</span>
                                    Join Meeting
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Detail Modal -->
            <div class="modal fade" id="detailModal<?php echo $appointment['id']; ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold"><?php echo htmlspecialchars($appointment['service_title']); ?></h5>
                            <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <h6 class="fw-bold mb-2">Your Request:</h6>
                            <p class="text-muted"><?php echo nl2br(htmlspecialchars($appointment['description'])); ?></p>
                            
                            <?php if ($appointment['notes']): ?>
                                <h6 class="fw-bold mb-2 mt-3">Staff Notes:</h6>
                                <p class="text-muted"><?php echo nl2br(htmlspecialchars($appointment['notes'])); ?></p>
                            <?php endif; ?>
                            
                            <?php if ($appointment['document_path']): ?>
                                <h6 class="fw-bold mb-2 mt-3">Attached Document:</h6>
                                <a href="<?php echo BASE_URL . $appointment['document_path']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <span class="material-icons" style="vertical-align: middle;">download</span>
                                    Download Document
                                </a>
                            <?php endif; ?>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge bg-<?php echo getStatusBadgeClass($appointment['status']); ?>">
                                        <?php echo ucfirst($appointment['status']); ?>
                                    </span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Category</small>
                                    <strong><?php echo ucfirst($appointment['category']); ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
function cancelAppointment(id) {
    if (confirm('Are you sure you want to cancel this appointment?')) {
        window.location.href = 'cancel-appointment.php?id=' + id;
    }
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
