<?php
require_once __DIR__ . '/config/config.php';
requireLogin();

$appointmentId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$appointmentId) {
    redirect('appointments.php');
}

$user = getCurrentUser();
$db = Database::getInstance()->getConnection();

// Verify appointment belongs to user
$stmt = $db->prepare("SELECT * FROM appointments WHERE id = ? AND student_id = ?");
$stmt->execute([$appointmentId, $user['id']]);
$appointment = $stmt->fetch();

if (!$appointment) {
    redirect('appointments.php');
}

// Check if appointment can be cancelled
if (!in_array($appointment['status'], ['pending', 'accepted'])) {
    $_SESSION['error'] = 'This appointment cannot be cancelled.';
    redirect('appointments.php');
}

// Update status to cancelled
$stmt = $db->prepare("UPDATE appointments SET status = 'cancelled' WHERE id = ?");
$stmt->execute([$appointmentId]);

$_SESSION['success'] = 'Appointment cancelled successfully.';
redirect('appointments.php');
