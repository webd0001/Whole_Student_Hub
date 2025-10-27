<?php
/**
 * Global Configuration
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL Configuration
define('BASE_URL', 'http://localhost/Whole%20Student%20Hub/');
define('ASSETS_URL', BASE_URL . 'assets/');

// File Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_EXTENSIONS', ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif']);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Error Reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
require_once __DIR__ . '/database.php';

// Helper Functions
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('auth/login.php');
    }
}

function requireRole($roles) {
    requireLogin();
    if (!in_array($_SESSION['user_role'], (array)$roles)) {
        redirect('index.php');
    }
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

function formatDateTime($datetime) {
    return date('M d, Y h:i A', strtotime($datetime));
}

function getStatusBadgeClass($status) {
    $classes = [
        'pending' => 'warning',
        'accepted' => 'info',
        'ongoing' => 'primary',
        'completed' => 'success',
        'cancelled' => 'secondary',
        'rejected' => 'danger',
        'open' => 'warning',
        'assigned' => 'info',
        'in-progress' => 'primary',
        'resolved' => 'success',
        'closed' => 'secondary'
    ];
    return $classes[$status] ?? 'secondary';
}

function uploadFile($file, $directory = 'documents') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'No file uploaded or upload error'];
    }
    
    $fileSize = $file['size'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if ($fileSize > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'File size exceeds maximum limit'];
    }
    
    if (!in_array($fileExt, ALLOWED_EXTENSIONS)) {
        return ['success' => false, 'message' => 'File type not allowed'];
    }
    
    $uploadPath = UPLOAD_DIR . $directory . '/';
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true);
    }
    
    $newFileName = uniqid() . '_' . time() . '.' . $fileExt;
    $destination = $uploadPath . $newFileName;
    
    if (move_uploaded_file($fileTmpName, $destination)) {
        return [
            'success' => true,
            'path' => 'uploads/' . $directory . '/' . $newFileName,
            'filename' => $newFileName,
            'size' => $fileSize
        ];
    }
    
    return ['success' => false, 'message' => 'Failed to move uploaded file'];
}

function sendEmail($to, $subject, $message) {
    // Email configuration - implement with PHPMailer or similar
    // For now, return true as placeholder
    return true;
}

function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}
