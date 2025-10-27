<?php
require_once __DIR__ . '/../config/config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    
    if (empty($email)) {
        $error = 'Please enter your email address';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } else {
        $db = Database::getInstance()->getConnection();
        
        // Check if email exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Generate reset token
            $token = generateToken();
            $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store token
            $stmt = $db->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$email, $token, $expiresAt]);
            
            // In production, send email with reset link
            // For now, show the reset link (for development)
            $resetLink = BASE_URL . "auth/reset-password.php?token=" . $token;
            $success = "Password reset link has been sent to your email. <br><small>Development mode: <a href='$resetLink'>Click here to reset</a></small>";
        } else {
            // Don't reveal if email exists (security)
            $success = 'If an account exists with this email, you will receive a password reset link.';
        }
    }
}

$pageTitle = 'Forgot Password - Whole Student Hub';
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
                <span class="material-icons" style="font-size: 60px; color: var(--primary-color);">lock_reset</span>
                <h3 class="fw-bold mt-3 mb-2">Forgot Password?</h3>
                <p class="text-muted">Enter your email address and we'll send you a link to reset your password.</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="material-icons" style="vertical-align: middle; font-size: 20px;">error</span>
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="material-icons" style="vertical-align: middle; font-size: 20px;">check_circle</span>
                    <?php echo $success; ?>
                    <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" required />
                    <label class="form-label" for="email">Email Address</label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block mb-4">
                    <span class="material-icons" style="vertical-align: middle;">send</span>
                    Send Reset Link
                </button>
                
                <div class="text-center">
                    <p>Remember your password? <a href="login.php" class="text-primary fw-bold">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
