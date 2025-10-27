<?php
/**
 * Setup Verification Script
 * This file checks if the installation is complete and properly configured
 */

$errors = [];
$warnings = [];
$success = [];

// Check PHP version
if (version_compare(PHP_VERSION, '7.4.0', '>=')) {
    $success[] = "✓ PHP version " . PHP_VERSION . " (OK)";
} else {
    $errors[] = "✗ PHP version " . PHP_VERSION . " is too old. Required: 7.4+";
}

// Check required PHP extensions
$requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'fileinfo'];
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        $success[] = "✓ PHP extension '$ext' is loaded";
    } else {
        $errors[] = "✗ PHP extension '$ext' is missing";
    }
}

// Check config files
$configFiles = [
    'config/config.php',
    'config/database.php',
    'database/schema.sql'
];

foreach ($configFiles as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        $success[] = "✓ File '$file' exists";
    } else {
        $errors[] = "✗ File '$file' is missing";
    }
}

// Check upload directories
$uploadDirs = [
    'uploads',
    'uploads/documents',
    'uploads/appointments',
    'uploads/resources',
    'uploads/profiles'
];

foreach ($uploadDirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (is_dir($path)) {
        if (is_writable($path)) {
            $success[] = "✓ Directory '$dir' exists and is writable";
        } else {
            $warnings[] = "⚠ Directory '$dir' exists but is not writable";
        }
    } else {
        $errors[] = "✗ Directory '$dir' does not exist";
    }
}

// Check database connection
try {
    require_once __DIR__ . '/config/database.php';
    $db = Database::getInstance()->getConnection();
    $success[] = "✓ Database connection successful";
    
    // Check if tables exist
    $tables = [
        'users', 'services', 'appointments', 'resources', 
        'password_resets', 'settings', 'support_tickets'
    ];
    
    foreach ($tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            $success[] = "✓ Table '$table' exists";
        } else {
            $errors[] = "✗ Table '$table' does not exist";
        }
    }
    
    // Check if admin user exists
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
    $result = $stmt->fetch();
    if ($result['count'] > 0) {
        $success[] = "✓ Admin user exists";
    } else {
        $warnings[] = "⚠ No admin user found";
    }
    
} catch (Exception $e) {
    $errors[] = "✗ Database connection failed: " . $e->getMessage();
}

// Check .htaccess
if (file_exists(__DIR__ . '/.htaccess')) {
    $success[] = "✓ .htaccess file exists";
} else {
    $warnings[] = "⚠ .htaccess file is missing (optional but recommended)";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Verification - Whole Student Hub</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 900px;
            margin: 2rem auto;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        .check-item {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
        }
        .success-item {
            background: #d4edda;
            color: #155724;
        }
        .error-item {
            background: #f8d7da;
            color: #721c24;
        }
        .warning-item {
            background: #fff3cd;
            color: #856404;
        }
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            margin-right: 0.5rem;
        }
        .status-ok {
            background: #28a745;
            color: white;
        }
        .status-warning {
            background: #ffc107;
            color: #000;
        }
        .status-error {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body text-center py-5">
                <span class="material-icons" style="font-size: 80px; color: #1976d2;">verified</span>
                <h2 class="fw-bold mt-3 mb-2">Setup Verification</h2>
                <p class="text-muted">Checking your Whole Student Hub installation...</p>
            </div>
        </div>
        
        <!-- Overall Status -->
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Overall Status</h5>
                <div>
                    <?php if (empty($errors)): ?>
                        <span class="status-badge status-ok">
                            <span class="material-icons" style="vertical-align: middle; font-size: 20px;">check_circle</span>
                            Installation Complete
                        </span>
                        <p class="mt-3 mb-0">Your installation is ready to use! You can now access the application.</p>
                    <?php elseif (empty($errors) && !empty($warnings)): ?>
                        <span class="status-badge status-warning">
                            <span class="material-icons" style="vertical-align: middle; font-size: 20px;">warning</span>
                            Installation Complete with Warnings
                        </span>
                        <p class="mt-3 mb-0">Your installation is functional but has some warnings. Please review below.</p>
                    <?php else: ?>
                        <span class="status-badge status-error">
                            <span class="material-icons" style="vertical-align: middle; font-size: 20px;">error</span>
                            Installation Incomplete
                        </span>
                        <p class="mt-3 mb-0">Please fix the errors below before using the application.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Errors -->
        <?php if (!empty($errors)): ?>
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3 text-danger">
                    <span class="material-icons" style="vertical-align: middle;">error</span>
                    Errors (<?php echo count($errors); ?>)
                </h5>
                <?php foreach ($errors as $error): ?>
                    <div class="check-item error-item"><?php echo $error; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Warnings -->
        <?php if (!empty($warnings)): ?>
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3 text-warning">
                    <span class="material-icons" style="vertical-align: middle;">warning</span>
                    Warnings (<?php echo count($warnings); ?>)
                </h5>
                <?php foreach ($warnings as $warning): ?>
                    <div class="check-item warning-item"><?php echo $warning; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Success -->
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3 text-success">
                    <span class="material-icons" style="vertical-align: middle;">check_circle</span>
                    Passed Checks (<?php echo count($success); ?>)
                </h5>
                <?php foreach ($success as $item): ?>
                    <div class="check-item success-item"><?php echo $item; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Next Steps -->
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Next Steps</h5>
                <ol>
                    <li class="mb-2">
                        <strong>Access the Application:</strong>
                        <a href="index.php" class="btn btn-sm btn-primary ms-2">Go to Homepage</a>
                    </li>
                    <li class="mb-2">
                        <strong>Login as Admin:</strong>
                        <ul>
                            <li>Email: admin@wholestudent.com</li>
                            <li>Password: admin123</li>
                        </ul>
                        <a href="auth/login.php" class="btn btn-sm btn-outline-primary">Login</a>
                    </li>
                    <li class="mb-2">
                        <strong>Change Admin Password:</strong> Go to Profile after logging in
                    </li>
                    <li class="mb-2">
                        <strong>Add Services:</strong> Navigate to Admin Panel → Services
                    </li>
                    <li class="mb-2">
                        <strong>Review Documentation:</strong>
                        <a href="README.md" class="btn btn-sm btn-outline-secondary ms-2">README</a>
                        <a href="INSTALLATION.md" class="btn btn-sm btn-outline-secondary ms-2">Installation Guide</a>
                    </li>
                </ol>
            </div>
        </div>
        
        <!-- Delete This File -->
        <div class="card bg-light">
            <div class="card-body text-center">
                <p class="mb-2">
                    <span class="material-icons text-warning" style="vertical-align: middle;">info</span>
                    <strong>Security Note:</strong> Delete this file (setup-check.php) after verification for security reasons.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
