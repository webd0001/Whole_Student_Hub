<?php
require_once __DIR__ . '/config/config.php';
requireLogin();

$user = getCurrentUser();
$db = Database::getInstance()->getConnection();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $department = sanitize($_POST['department'] ?? '');
    $academic_year = sanitize($_POST['academic_year'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $bio = sanitize($_POST['bio'] ?? '');
    
    // Check if email is already taken by another user
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->execute([$email, $user['id']]);
    if ($stmt->fetch()) {
        $error = 'Email already in use by another account';
    } else {
        // Update profile
        $stmt = $db->prepare("
            UPDATE users 
            SET name = ?, email = ?, department = ?, academic_year = ?, phone = ?, bio = ? 
            WHERE id = ?
        ");
        
        if ($stmt->execute([$name, $email, $department, $academic_year, $phone, $bio, $user['id']])) {
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $success = 'Profile updated successfully!';
            $user = getCurrentUser(); // Refresh user data
        } else {
            $error = 'Failed to up date profile';
        }
    }
}

$pageTitle = 'My Profile - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    .profile-header {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
    
    .profile-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1976d2, #1565c0);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 600;
        margin: 0 auto 1rem;
    }
</style>

<!-- Header -->
<div class="profile-header">
    <div class="container">
        <h1 class="fw-bold mb-2">My Profile</h1>
        <p class="mb-0 opacity-90">Manage your account information</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="profile-card text-center">
                <div class="profile-avatar">
                    <?php echo strtoupper(substr($user['name'], 0, 2)); ?>
                </div>
                <h4 class="fw-bold mb-1"><?php echo htmlspecialchars($user['name']); ?></h4>
                <p class="text-muted mb-3"><?php echo ucfirst($user['role']); ?></p>
                <p class="text-muted small">
                    <span class="material-icons" style="vertical-align: middle; font-size: 16px;">email</span>
                    <?php echo htmlspecialchars($user['email']); ?>
                </p>
                <p class="text-muted small">
                    <span class="material-icons" style="vertical-align: middle; font-size: 16px;">schedule</span>
                    Member since <?php echo formatDate($user['created_at']); ?>
                </p>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="profile-card">
                <h5 class="fw-bold mb-4">Edit Profile</h5>
                
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
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-outline">
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required />
                                <label class="form-label" for="name">Full Name</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-outline">
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required />
                                <label class="form-label" for="email">Email Address</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-outline">
                                <input type="text" id="department" name="department" class="form-control" value="<?php echo htmlspecialchars($user['department'] ?? ''); ?>" />
                                <label class="form-label" for="department">Department</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <select class="form-select" name="academic_year">
                                <option value="">Academic Year</option>
                                <option value="freshman" <?php echo $user['academic_year'] === 'freshman' ? 'selected' : ''; ?>>Freshman</option>
                                <option value="sophomore" <?php echo $user['academic_year'] === 'sophomore' ? 'selected' : ''; ?>>Sophomore</option>
                                <option value="junior" <?php echo $user['academic_year'] === 'junior' ? 'selected' : ''; ?>>Junior</option>
                                <option value="senior" <?php echo $user['academic_year'] === 'senior' ? 'selected' : ''; ?>>Senior</option>
                                <option value="graduate" <?php echo $user['academic_year'] === 'graduate' ? 'selected' : ''; ?>>Graduate</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <div class="form-outline">
                                <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" />
                                <label class="form-label" for="phone">Phone Number</label>
                            </div>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <div class="form-outline">
                                <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                                <label class="form-label" for="bio">Bio</label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <span class="material-icons" style="vertical-align: middle;">save</span>
                        Save Changes
                    </button>
                </form>
            </div>
            
            <div class="profile-card">
                <h5 class="fw-bold mb-3">Change Password</h5>
                <a href="change-password.php" class="btn btn-outline-primary">
                    <span class="material-icons" style="vertical-align: middle;">lock</span>
                    Update Password
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
