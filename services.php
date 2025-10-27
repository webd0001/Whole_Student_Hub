<?php
require_once __DIR__ . '/config/config.php';

$db = Database::getInstance()->getConnection();

// Get filter parameters
$category = isset($_GET['category']) ? sanitize($_GET['category']) : '';
$mode = isset($_GET['mode']) ? sanitize($_GET['mode']) : '';
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

// Build query
$query = "SELECT s.*, u.name as staff_name FROM services s LEFT JOIN users u ON s.assigned_staff_id = u.id WHERE s.is_active = 1";
$params = [];

if ($category) {
    $query .= " AND s.category = ?";
    $params[] = $category;
}

if ($mode) {
    $query .= " AND (s.mode = ? OR s.mode = 'both')";
    $params[] = $mode;
}

if ($search) {
    $query .= " AND (s.title LIKE ? OR s.description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$query .= " ORDER BY s.created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$services = $stmt->fetchAll();

$pageTitle = 'Services - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    .services-header {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
    
    .filter-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .service-card {
        background: var(--card-bg);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    
    .service-icon {
        width: 100%;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        color: white;
    }
    
    .service-icon.academic {
        background: linear-gradient(135deg, #2196f3, #1976d2);
    }
    
    .service-icon.counseling {
        background: linear-gradient(135deg, #4caf50, #2e7d32);
    }
    
    .service-icon.career {
        background: linear-gradient(135deg, #9c27b0, #7b1fa2);
    }
    
    .service-icon.mentorship {
        background: linear-gradient(135deg, #ff9800, #f57c00);
    }
    
    .service-icon.workshop {
        background: linear-gradient(135deg, #00bcd4, #0097a7);
    }
    
    .service-icon.other {
        background: linear-gradient(135deg, #607d8b, #455a64);
    }
    
    .service-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .service-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(0,0,0,0.1);
        margin-top: auto;
    }
    
    .category-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
</style>

<!-- Header -->
<div class="services-header">
    <div class="container">
        <h1 class="fw-bold mb-2">Our Services</h1>
        <p class="mb-0 opacity-90">Comprehensive support for your academic and personal growth</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Filters -->
    <div class="filter-card">
        <form method="GET" action="">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-outline">
                        <input type="text" id="search" name="search" class="form-control" value="<?php echo htmlspecialchars($search); ?>" />
                        <label class="form-label" for="search">Search services...</label>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        <option value="academic" <?php echo $category === 'academic' ? 'selected' : ''; ?>>Academic</option>
                        <option value="counseling" <?php echo $category === 'counseling' ? 'selected' : ''; ?>>Counseling</option>
                        <option value="career" <?php echo $category === 'career' ? 'selected' : ''; ?>>Career</option>
                        <option value="mentorship" <?php echo $category === 'mentorship' ? 'selected' : ''; ?>>Mentorship</option>
                        <option value="workshop" <?php echo $category === 'workshop' ? 'selected' : ''; ?>>Workshop</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <select class="form-select" name="mode">
                        <option value="">All Modes</option>
                        <option value="online" <?php echo $mode === 'online' ? 'selected' : ''; ?>>Online</option>
                        <option value="offline" <?php echo $mode === 'offline' ? 'selected' : ''; ?>>In-Person</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <span class="material-icons" style="vertical-align: middle;">search</span>
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Services Grid -->
    <?php if (empty($services)): ?>
        <div class="text-center py-5">
            <span class="material-icons" style="font-size: 100px; color: var(--text-secondary); opacity: 0.3;">search_off</span>
            <h4 class="mt-3">No services found</h4>
            <p class="text-muted">Try adjusting your filters</p>
            <a href="services.php" class="btn btn-primary">Clear Filters</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($services as $service): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon <?php echo $service['category']; ?>">
                            <span class="material-icons">
                                <?php
                                $icons = [
                                    'academic' => 'school',
                                    'counseling' => 'psychology',
                                    'career' => 'work',
                                    'mentorship' => 'groups',
                                    'workshop' => 'event',
                                    'other' => 'help'
                                ];
                                echo $icons[$service['category']] ?? 'help';
                                ?>
                            </span>
                        </div>
                        
                        <div class="service-body">
                            <span class="category-badge" style="background: rgba(25, 118, 210, 0.1); color: #1976d2;">
                                <?php echo ucfirst($service['category']); ?>
                            </span>
                            <h5 class="fw-bold mb-2"><?php echo htmlspecialchars($service['title']); ?></h5>
                            <p class="text-muted mb-3">
                                <?php echo htmlspecialchars(substr($service['description'], 0, 120)) . '...'; ?>
                            </p>
                            
                            <div class="mb-2">
                                <small class="text-muted">
                                    <span class="material-icons" style="vertical-align: middle; font-size: 16px;">schedule</span>
                                    <?php echo $service['duration_minutes']; ?> minutes
                                </small>
                            </div>
                            
                            <div class="mb-2">
                                <small class="text-muted">
                                    <span class="material-icons" style="vertical-align: middle; font-size: 16px;">location_on</span>
                                    <?php echo ucfirst($service['mode']); ?>
                                </small>
                            </div>
                            
                            <?php if ($service['staff_name']): ?>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <span class="material-icons" style="vertical-align: middle; font-size: 16px;">person</span>
                                        <?php echo htmlspecialchars($service['staff_name']); ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="service-footer">
                            <a href="service-detail.php?id=<?php echo $service['id']; ?>" class="btn btn-primary w-100">
                                <span class="material-icons" style="vertical-align: middle;">visibility</span>
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
