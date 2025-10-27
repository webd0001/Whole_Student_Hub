<?php
require_once __DIR__ . '/../config/config.php';
requireRole(['admin', 'counselor', 'mentor']);

$user = getCurrentUser();
$db = Database::getInstance()->getConnection();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $appointmentId = (int)$_POST['appointment_id'];
    $status = sanitize($_POST['status']);
    $notes = sanitize($_POST['notes'] ?? '');
    $meetingLink = sanitize($_POST['meeting_link'] ?? '');
    
    $stmt = $db->prepare("
        UPDATE appointments 
        SET status = ?, notes = ?, meeting_link = ?, staff_id = ? 
        WHERE id = ?
    ");
    $stmt->execute([$status, $notes, $meetingLink, $user['id'], $appointmentId]);
    
    $_SESSION['success'] = 'Appointment updated successfully';
    header("Location: appointments.php");
    exit();
}

// Get filter parameters
$statusFilter = isset($_GET['status']) ? sanitize($_GET['status']) : '';

// Build query
$query = "
    SELECT a.*, s.title as service_title, s.category, 
           u1.name as student_name, u1.email as student_email,
           u2.name as staff_name 
    FROM appointments a 
    LEFT JOIN services s ON a.service_id = s.id 
    LEFT JOIN users u1 ON a.student_id = u1.id 
    LEFT JOIN users u2 ON a.staff_id = u2.id 
    WHERE 1=1
";
$params = [];

if ($statusFilter) {
    $query .= " AND a.status = ?";
    $params[] = $statusFilter;
}

$query .= " ORDER BY a.created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$appointments = $stmt->fetchAll();

$pageTitle = 'Manage Appointments - Admin';
include __DIR__ . '/header.php';
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Manage Appointments</h4>
    </div>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Filter Tabs -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="btn-group" role="group">
                <a href="?status=" class="btn btn-<?php echo $statusFilter === '' ? 'primary' : 'outline-primary'; ?>">All</a>
                <a href="?status=pending" class="btn btn-<?php echo $statusFilter === 'pending' ? 'warning' : 'outline-warning'; ?>">Pending</a>
                <a href="?status=accepted" class="btn btn-<?php echo $statusFilter === 'accepted' ? 'info' : 'outline-info'; ?>">Accepted</a>
                <a href="?status=ongoing" class="btn btn-<?php echo $statusFilter === 'ongoing' ? 'primary' : 'outline-primary'; ?>">Ongoing</a>
                <a href="?status=completed" class="btn btn-<?php echo $statusFilter === 'completed' ? 'success' : 'outline-success'; ?>">Completed</a>
            </div>
        </div>
    </div>
    
    <!-- Appointments Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Service</th>
                            <th>Category</th>
                            <th>Mode</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($appointments)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No appointments found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td>#<?php echo $appointment['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($appointment['student_name']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($appointment['student_email']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($appointment['service_title']); ?></td>
                                    <td><span class="badge bg-secondary"><?php echo ucfirst($appointment['category']); ?></span></td>
                                    <td><span class="badge bg-info"><?php echo ucfirst($appointment['mode']); ?></span></td>
                                    <td>
                                        <span class="badge bg-<?php echo getStatusBadgeClass($appointment['status']); ?>">
                                            <?php echo ucfirst($appointment['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo formatDateTime($appointment['created_at']); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-mdb-toggle="modal" data-mdb-target="#detailModal<?php echo $appointment['id']; ?>">
                                            <span class="material-icons" style="font-size: 16px;">visibility</span>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Detail Modal -->
                                <div class="modal fade" id="detailModal<?php echo $appointment['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Appointment #<?php echo $appointment['id']; ?></h5>
                                                <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="">
                                                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                                                    <input type="hidden" name="update_status" value="1">
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <strong>Student:</strong><br>
                                                            <?php echo htmlspecialchars($appointment['student_name']); ?><br>
                                                            <small class="text-muted"><?php echo htmlspecialchars($appointment['student_email']); ?></small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Service:</strong><br>
                                                            <?php echo htmlspecialchars($appointment['service_title']); ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <strong>Student's Request:</strong>
                                                        <p class="text-muted"><?php echo nl2br(htmlspecialchars($appointment['description'])); ?></p>
                                                    </div>
                                                    
                                                    <?php if ($appointment['document_path']): ?>
                                                        <div class="mb-3">
                                                            <strong>Attached Document:</strong><br>
                                                            <a href="<?php echo BASE_URL . $appointment['document_path']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <span class="material-icons" style="vertical-align: middle; font-size: 16px;">download</span>
                                                                Download
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <hr>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Status</label>
                                                            <select class="form-select" name="status" required>
                                                                <option value="pending" <?php echo $appointment['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="accepted" <?php echo $appointment['status'] === 'accepted' ? 'selected' : ''; ?>>Accepted</option>
                                                                <option value="ongoing" <?php echo $appointment['status'] === 'ongoing' ? 'selected' : ''; ?>>Ongoing</option>
                                                                <option value="completed" <?php echo $appointment['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                                <option value="rejected" <?php echo $appointment['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Meeting Link (Optional)</label>
                                                            <input type="url" class="form-control" name="meeting_link" value="<?php echo htmlspecialchars($appointment['meeting_link'] ?? ''); ?>" placeholder="https://meet.google.com/...">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Notes</label>
                                                        <textarea class="form-control" name="notes" rows="3"><?php echo htmlspecialchars($appointment['notes'] ?? ''); ?></textarea>
                                                    </div>
                                                    
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <span class="material-icons" style="vertical-align: middle; font-size: 16px;">save</span>
                                                            Update
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
