<?php
require_once __DIR__ . '/../config/config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = sanitize($_POST['role']);
    $department = sanitize($_POST['department'] ?? '');
    $academic_year = sanitize($_POST['academic_year'] ?? '');
    
    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $error = 'Please fill in all required fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (!in_array($role, ['student', 'mentor', 'counselor'])) {
        $error = 'Invalid role selected';
    } else {
        $db = Database::getInstance()->getConnection();
        
        // Check if email already exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email already registered';
        } else {
            // Insert new user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (name, email, password, role, department, academic_year) VALUES (?, ?, ?, ?, ?, ?)");
            
            if ($stmt->execute([$name, $email, $hashedPassword, $role, $department, $academic_year])) {
                redirect('login.php?registered=1');
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}

$pageTitle = 'Sign Up - Whole Student Hub';
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
        background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
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
        .auth-right {
            padding: 2rem;
        }
    }
</style>

<div class="auth-container">
    <div class="container">
        <div class="auth-card">
            <div class="row g-0">
                <div class="col-md-5 auth-left">
                    <h2 class="fw-bold mb-4">Join Our Community!</h2>
                    <p class="mb-4">Create your account and start your journey towards academic excellence and personal well-being.</p>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <span class="material-icons" style="vertical-align: middle;">psychology</span>
                            Mental health support
                        </li>
                        <li class="mb-3">
                            <span class="material-icons" style="vertical-align: middle;">school</span>
                            Academic guidance
                        </li>
                        <li class="mb-3">
                            <span class="material-icons" style="vertical-align: middle;">groups</span>
                            Peer mentorship
                        </li>
                        <li class="mb-3">
                            <span class="material-icons" style="vertical-align: middle;">work</span>
                            Career counseling
                        </li>
                    </ul>
                </div>
                
                <div class="col-md-7 auth-right">
                    <h3 class="fw-bold mb-4">Create Account</h3>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="material-icons" style="vertical-align: middle; font-size: 20px;">error</span>
                            <?php echo $error; ?>
                            <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-outline mb-3">
                                    <input type="text" id="name" name="name" class="form-control" required />
                                    <label class="form-label" for="name">Full Name</label>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-outline mb-3">
                                    <input type="email" id="email" name="email" class="form-control" required />
                                    <label class="form-label" for="email">Email Address</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-outline mb-3">
                                    <input type="password" id="password" name="password" class="form-control" required />
                                    <label class="form-label" for="password">Password</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-outline mb-3">
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required />
                                    <label class="form-label" for="confirm_password">Confirm Password</label>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <select class="form-select mb-3" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="student">Student</option>
                                    <option value="mentor">Mentor</option>
                                    <option value="counselor">Counselor</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-outline mb-3">
                                    <input type="text" id="department" name="department" class="form-control" />
                                    <label class="form-label" for="department">Department (Optional)</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <select class="form-select mb-3" name="academic_year">
                                    <option value="">Academic Year (Optional)</option>
                                    <option value="freshman">Freshman</option>
                                    <option value="sophomore">Sophomore</option>
                                    <option value="junior">Junior</option>
                                    <option value="senior">Senior</option>
                                    <option value="graduate">Graduate</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" required />
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="<?php echo BASE_URL; ?>terms.php" target="_blank">Terms of Service</a> and <a href="<?php echo BASE_URL; ?>privacy.php" target="_blank">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-block mb-4">
                            <span class="material-icons" style="vertical-align: middle;">person_add</span>
                            Create Account
                        </button>
                        
                        <div class="text-center">
                            <p>Already have an account? <a href="login.php" class="text-primary fw-bold">Sign In</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
