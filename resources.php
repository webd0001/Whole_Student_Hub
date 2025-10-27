<?php
require_once __DIR__ . '/config/config.php';

$db = Database::getInstance()->getConnection();

// Get filter parameters
$category = isset($_GET['category']) ? sanitize($_GET['category']) : '';
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

// Build query
$query = "SELECT r.*, u.name as uploaded_by_name FROM resources r LEFT JOIN users u ON r.uploaded_by = u.id WHERE r.is_active = 1";
$params = [];

// Check visibility based on login status
if (isLoggedIn()) {
    $user = getCurrentUser();
    $query .= " AND (r.visibility = 'public' OR r.visibility = 'members' OR (r.visibility = 'role-based' AND FIND_IN_SET(?, r.allowed_roles)))";
    $params[] = $user['role'];
} else {
    $query .= " AND r.visibility = 'public'";
}

if ($category) {
    $query .= " AND r.category = ?";
    $params[] = $category;
}

if ($search) {
    $query .= " AND (r.title LIKE ? OR r.description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$query .= " ORDER BY r.created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$resources = $stmt->fetchAll();

$pageTitle = 'Resource Library - Whole Student Hub';
include __DIR__ . '/includes/header.php';
?>

<style>
    .resources-header {
        background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
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
    
    .resource-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .resource-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    
    .resource-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        flex-shrink: 0;
    }
    
    .resource-icon.pdf {
        background: linear-gradient(135deg, #f44336, #d32f2f);
        color: white;
    }
    
    .resource-icon.doc {
        background: linear-gradient(135deg, #2196f3, #1976d2);
        color: white;
    }
    
    .resource-icon.image {
        background: linear-gradient(135deg, #4caf50, #2e7d32);
        color: white;
    }
    
    .resource-icon.other {
        background: linear-gradient(135deg, #607d8b, #455a64);
        color: white;
    }
    
    .resource-content {
        flex-grow: 1;
    }
    
    .resource-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }
    
    .resource-meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }
    
    @media (max-width: 768px) {
        .resource-card {
            flex-direction: column;
            text-align: center;
        }
        
        .resource-meta {
            justify-content: center;
        }
    }
</style>

<!-- Header -->
<div class="resources-header">
    <div class="container">
        <h1 class="fw-bold mb-2">Resource Library</h1>
        <p class="mb-0 opacity-90">Access study materials, guides, and helpful resources</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Filters -->
    <div class="filter-card">
        <form method="GET" action="">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-outline">
                        <input type="text" id="search" name="search" class="form-control" value="<?php echo htmlspecialchars($search); ?>" />
                        <label class="form-label" for="search">Search resources...</label>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        <option value="wellbeing" <?php echo $category === 'wellbeing' ? 'selected' : ''; ?>>Well-being</option>
                        <option value="academic" <?php echo $category === 'academic' ? 'selected' : ''; ?>>Academic</option>
                        <option value="career" <?php echo $category === 'career' ? 'selected' : ''; ?>>Career</option>
                        <option value="general" <?php echo $category === 'general' ? 'selected' : ''; ?>>General</option>
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
    
    <!-- Resources List -->
    <?php if (empty($resources)): ?>
        <div class="text-center py-5">
            <span class="material-icons" style="font-size: 100px; color: var(--text-secondary); opacity: 0.3;">folder_open</span>
            <h4 class="mt-3">No resources found</h4>
            <p class="text-muted">Try adjusting your filters or check back later</p>
            <a href="resources.php" class="btn btn-primary">Clear Filters</a>
        </div>
    <?php else: ?>
        <?php foreach ($resources as $resource): ?>
            <div class="resource-card">
                <div class="resource-icon <?php 
                    $ext = strtolower(pathinfo($resource['file_path'], PATHINFO_EXTENSION));
                    if ($ext === 'pdf') echo 'pdf';
                    elseif (in_array($ext, ['doc', 'docx'])) echo 'doc';
                    elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) echo 'image';
                    else echo 'other';
                ?>">
                    <span class="material-icons">
                        <?php 
                        if ($ext === 'pdf') echo 'picture_as_pdf';
                        elseif (in_array($ext, ['doc', 'docx'])) echo 'description';
                        elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) echo 'image';
                        else echo 'insert_drive_file';
                        ?>
                    </span>
                </div>
                
                <div class="resource-content">
                    <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($resource['title']); ?></h5>
                    <?php if ($resource['description']): ?>
                        <p class="text-muted mb-2"><?php echo htmlspecialchars($resource['description']); ?></p>
                    <?php endif; ?>
                    
                    <div class="resource-meta">
                        <span class="resource-meta-item">
                            <span class="material-icons" style="font-size: 16px;">category</span>
                            <?php echo ucfirst($resource['category']); ?>
                        </span>
                        <span class="resource-meta-item">
                            <span class="material-icons" style="font-size: 16px;">file_present</span>
                            <?php echo strtoupper($ext); ?>
                        </span>
                        <?php if ($resource['file_size']): ?>
                            <span class="resource-meta-item">
                                <span class="material-icons" style="font-size: 16px;">storage</span>
                                <?php echo round($resource['file_size'] / 1024 / 1024, 2); ?> MB
                            </span>
                        <?php endif; ?>
                        <span class="resource-meta-item">
                            <span class="material-icons" style="font-size: 16px;">download</span>
                            <?php echo $resource['download_count']; ?> downloads
                        </span>
                        <span class="resource-meta-item">
                            <span class="material-icons" style="font-size: 16px;">schedule</span>
                            <?php echo formatDate($resource['created_at']); ?>
                        </span>
                    </div>
                </div>
                
                <div>
                    <?php if (isLoggedIn()): ?>
                        <a href="download-resource.php?id=<?php echo $resource['id']; ?>" class="btn btn-primary">
                            <span class="material-icons" style="vertical-align: middle;">download</span>
                            Download
                        </a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>auth/login.php" class="btn btn-outline-primary">
                            <span class="material-icons" style="vertical-align: middle;">login</span>
                            Login to Download
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
