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
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            if ($user['is_blocked']) {
                $error = 'Your account has been blocked. Please contact support.';
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Redirect based on role
                if (in_array($user['role'], ['admin', 'counselor', 'mentor'])) {
                    redirect('admin/index.php');
                } else {
                    redirect('dashboard.php');
                }
            }
        } else {
            $error = 'Invalid email or password';
        }
    }
}

$pageTitle = 'Login - Whole Student Hub';
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
        max-width: 1000px;
        width: 100%;
    }
    
    .auth-left {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        color: white;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .auth-right {
        padding: 3rem;
    }
    
    .form-outline {
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .auth-left {
            display: none;
        }
    }
</style>

<div class="auth-container">
    <div class="container">
        <div class="auth-card">
            <div class="row g-0">
                <div class="col-md-5 auth-left">
                    <h2 class="fw-bold mb-4">Welcome Back!</h2>
                    <p class="mb-4">Sign in to access your personalized dashboard, connect with mentors, and get the support you need.</p>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <span class="material-icons" style="vertical-align: middle;">check_circle</span>
                            Access academic resources
                        </li>
                        <li class="mb-3">
                            <span class="material-icons" style="vertical-align: middle;">check_circle</span>
                            Book counseling sessions
                        </li>
                        <li class="mb-3">
                            <span class="material-icons" style="vertical-align: middle;">check_circle</span>
                            Connect with mentors
                        </li>
                        <li class="mb-3">
                            <span class="material-icons" style="vertical-align: middle;">check_circle</span>
                            Track your appointments
                        </li>
                    </ul>
                </div>
                
                <div class="col-md-7 auth-right">
                    <h3 class="fw-bold mb-4">Sign In</h3>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="material-icons" style="vertical-align: middle; font-size: 20px;">error</span>
                            <?php echo $error; ?>
                            <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_GET['registered'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span class="material-icons" style="vertical-align: middle; font-size: 20px;">check_circle</span>
                            Registration successful! Please login.
                            <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_GET['reset'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span class="material-icons" style="vertical-align: middle; font-size: 20px;">check_circle</span>
                            Password reset successful! Please login with your new password.
                            <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="form-outline mb-4">
                            <input type="email" id="email" name="email" class="form-control" required />
                            <label class="form-label" for="email">Email Address</label>
                        </div>
                        
                        <div class="form-outline mb-4">
                            <input type="password" id="password" name="password" class="form-control" required />
                            <label class="form-label" for="password">Password</label>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" />
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="forgot-password.php" class="text-primary">Forgot password?</a>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block mb-4">
                            <span class="material-icons" style="vertical-align: middle;">login</span>
                            Sign In
                        </button>
                        
                        <div class="text-center">
                            <p>Don't have an account? <a href="signup.php" class="text-primary fw-bold">Sign Up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
