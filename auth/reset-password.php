<?php
require_once __DIR__ . '/../config/config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';
$success = '';
$validToken = false;
$email = '';

// Verify token
if (isset($_GET['token'])) {
    $token = sanitize($_GET['token']);
    $db = Database::getInstance()->getConnection();
    
    $stmt = $db->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $resetRequest = $stmt->fetch();
    
    if ($resetRequest) {
        $validToken = true;
        $email = $resetRequest['email'];
    } else {
        $error = 'Invalid or expired reset token';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $validToken) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    if (empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all fields';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } else {
        $db = Database::getInstance()->getConnection();
        
        // Update password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
        
        if ($stmt->execute([$hashedPassword, $email])) {
            // Delete used token
            $stmt = $db->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmt->execute([$email]);
            
            redirect('login.php?reset=1');
        } else {
            $error = 'Failed to reset password. Please try again.';
        }
    }
}

$pageTitle = 'Reset Password - Whole Student Hub';
include __DIR__ . '/../includes/header.php';
?>

<style>
    .auth-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .auth-card {
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
        padding: 3rem;
    }
</style>

<div class="auth-container">
    <div class="container">
        <div class="auth-card">
            <div class="text-center mb-4">
                <span class="material-icons" style="font-size: 60px; color: var(--primary-color);">lock_open</span>
                <h3 class="fw-bold mt-3 mb-2">Reset Password</h3>
                <p class="text-muted">Enter your new password below</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="material-icons" style="vertical-align: middle; font-size: 20px;">error</span>
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if ($validToken): ?>
                <form method="POST" action="">
                    <div class="form-outline mb-4">
                        <input type="password" id="password" name="password" class="form-control" required />
                        <label class="form-label" for="password">New Password</label>
                    </div>
                    
                    <div class="form-outline mb-4">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required />
                        <label class="form-label" for="confirm_password">Confirm New Password</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block mb-4">
                        <span class="material-icons" style="vertical-align: middle;">check</span>
                        Reset Password
                    </button>
                </form>
            <?php else: ?>
                <div class="text-center">
                    <p class="text-muted mb-3">The reset link is invalid or has expired.</p>
                    <a href="forgot-password.php" class="btn btn-primary">Request New Link</a>
                </div>
            <?php endif; ?>
            
            <div class="text-center mt-3">
                <p><a href="login.php" class="text-primary">Back to Login</a></p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
