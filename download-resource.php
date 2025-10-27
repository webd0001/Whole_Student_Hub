<?php
require_once __DIR__ . '/config/config.php';
requireLogin();

$resourceId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$resourceId) {
    redirect('resources.php');
}

$user = getCurrentUser();
$db = Database::getInstance()->getConnection();

// Get resource details
$stmt = $db->prepare("SELECT * FROM resources WHERE id = ? AND is_active = 1");
$stmt->execute([$resourceId]);
$resource = $stmt->fetch();

if (!$resource) {
    redirect('resources.php');
}

// Check visibility permissions
$canDownload = false;

if ($resource['visibility'] === 'public' || $resource['visibility'] === 'members') {
    $canDownload = true;
} elseif ($resource['visibility'] === 'role-based') {
    $allowedRoles = explode(',', $resource['allowed_roles']);
    if (in_array($user['role'], $allowedRoles)) {
        $canDownload = true;
    }
}

if (!$canDownload) {
    die('You do not have permission to download this resource.');
}

// Track download
$stmt = $db->prepare("INSERT INTO resource_downloads (resource_id, user_id) VALUES (?, ?)");
$stmt->execute([$resourceId, $user['id']]);

// Update download count
$stmt = $db->prepare("UPDATE resources SET download_count = download_count + 1 WHERE id = ?");
$stmt->execute([$resourceId]);

// Serve file
$filePath = __DIR__ . '/' . $resource['file_path'];

if (!file_exists($filePath)) {
    die('File not found.');
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
header('Content-Length: ' . filesize($filePath));
readfile($filePath);
exit();
