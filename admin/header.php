<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/config.php';
requireRole(['admin', 'counselor', 'mentor']);
$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Admin - Whole Student Hub'; ?></title>
    
    <!-- Material Design Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1976d2;
            --sidebar-width: 260px;
            --topbar-height: 64px;
        }
        
        [data-theme="dark"] {
            --light-bg: #121212;
            --card-bg: #1e1e1e;
            --text-primary: #ffffff;
            --text-secondary: #b0b0b0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            color: #212121;
        }
        
        [data-theme="dark"] body {
            background-color: #121212;
            color: #ffffff;
        }
        
        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #1e1e1e;
            color: white;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .menu-item:hover,
        .menu-item.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .menu-item .material-icons {
            margin-right: 1rem;
        }
        
        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        .admin-topbar {
            background: white;
            height: var(--topbar-height);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        [data-theme="dark"] .admin-topbar {
            background: #1e1e1e;
        }
        
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <h5 class="fw-bold mb-0">
                <span class="material-icons" style="vertical-align: middle;">admin_panel_settings</span>
                Admin Panel
            </h5>
        </div>
        
        <div class="sidebar-menu">
            <a href="<?php echo BASE_URL; ?>admin/index.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <span class="material-icons">dashboard</span>
                Dashboard
            </a>
            
            <a href="<?php echo BASE_URL; ?>admin/appointments.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">
                <span class="material-icons">event</span>
                Appointments
            </a>
            
            <?php if ($currentUser['role'] === 'admin'): ?>
            <a href="<?php echo BASE_URL; ?>admin/services.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">
                <span class="material-icons">medical_services</span>
                Services
            </a>
            
            <a href="<?php echo BASE_URL; ?>admin/users.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                <span class="material-icons">people</span>
                Users
            </a>
            
            <a href="<?php echo BASE_URL; ?>admin/resources.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'resources.php' ? 'active' : ''; ?>">
                <span class="material-icons">library_books</span>
                Resources
            </a>
            
            <a href="<?php echo BASE_URL; ?>admin/tickets.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'tickets.php' ? 'active' : ''; ?>">
                <span class="material-icons">support_agent</span>
                Support Tickets
            </a>
            
            <a href="<?php echo BASE_URL; ?>admin/reports.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>">
                <span class="material-icons">analytics</span>
                Reports
            </a>
            
            <a href="<?php echo BASE_URL; ?>admin/settings.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                <span class="material-icons">settings</span>
                Settings
            </a>
            <?php endif; ?>
            
            <hr style="border-color: rgba(255,255,255,0.1); margin: 1rem 0;">
            
            <a href="<?php echo BASE_URL; ?>dashboard.php" class="menu-item">
                <span class="material-icons">home</span>
                User Dashboard
            </a>
            
            <a href="<?php echo BASE_URL; ?>auth/logout.php" class="menu-item">
                <span class="material-icons">logout</span>
                Logout
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-toggle" onclick="toggleSidebar()">
                    <span class="material-icons">menu</span>
                </button>
                <h5 class="fw-bold mb-0 ms-3"><?php echo $pageTitle ?? 'Admin Dashboard'; ?></h5>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm" onclick="toggleTheme()">
                    <span class="material-icons" id="themeIcon">dark_mode</span>
                </button>
                
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle" type="button" data-mdb-toggle="dropdown">
                        <span class="material-icons" style="vertical-align: middle;">account_circle</span>
                        <?php echo htmlspecialchars($currentUser['name']); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>profile.php">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>auth/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <script>
            function toggleSidebar() {
                document.getElementById('adminSidebar').classList.toggle('show');
            }
            
            function toggleTheme() {
                const html = document.documentElement;
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', newTheme);
                document.getElementById('themeIcon').textContent = newTheme === 'dark' ? 'light_mode' : 'dark_mode';
                localStorage.setItem('theme', newTheme);
            }
            
            document.addEventListener('DOMContentLoaded', function() {
                const savedTheme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-theme', savedTheme);
                document.getElementById('themeIcon').textContent = savedTheme === 'dark' ? 'light_mode' : 'dark_mode';
            });
        </script>
