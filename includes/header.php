<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/config.php';
$currentUser = getCurrentUser();
$isLoggedIn = isLoggedIn();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Whole Student Hub'; ?></title>
    
    <!-- Material Design Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #1976d2;
            --secondary-color: #424242;
            --success-color: #2e7d32;
            --danger-color: #d32f2f;
            --warning-color: #f57c00;
            --info-color: #0288d1;
            --light-bg: #f5f5f5;
            --dark-bg: #121212;
            --card-bg: #ffffff;
            --text-primary: #212121;
            --text-secondary: #757575;
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
            background-color: var(--light-bg);
            color: var(--text-primary);
            transition: background-color 0.3s ease;
        }
        
        /* Navbar Styles */
        .navbar {
            background: var(--card-bg);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }
        
        .nav-link {
            color: var(--text-primary) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .btn-theme-toggle {
            background: transparent;
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background 0.3s ease;
        }
        
        .btn-theme-toggle:hover {
            background: rgba(0,0,0,0.05);
        }
        
        /* Mobile Bottom Navigation */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--card-bg);
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            padding: 0.5rem 0;
        }
        
        .bottom-nav-item {
            flex: 1;
            text-align: center;
            padding: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: color 0.3s ease;
        }
        
        .bottom-nav-item.active,
        .bottom-nav-item:hover {
            color: var(--primary-color);
        }
        
        .bottom-nav-item .material-icons {
            font-size: 24px;
            margin-bottom: 0.25rem;
        }
        
        .bottom-nav-item span {
            font-size: 0.75rem;
        }
        
        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 999;
        }
        
        .fab:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0,0,0,0.4);
        }
        
        /* Card Styles */
        .custom-card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        
        .custom-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .desktop-nav {
                display: none !important;
            }
            
            .bottom-nav {
                display: flex;
            }
            
            .fab {
                bottom: 80px;
            }
            
            body {
                padding-bottom: 70px;
            }
        }
        
        @media (min-width: 769px) {
            .fab {
                bottom: 20px;
            }
        }
    </style>
    
    <?php if (isset($additionalCSS)) echo $additionalCSS; ?>
</head>
<body>
    <!-- Desktop Navigation -->
    <nav class="navbar navbar-expand-lg desktop-nav">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <span class="material-icons" style="vertical-align: middle;">school</span>
                Whole Student Hub
            </a>
            
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav">
                <span class="material-icons">menu</span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if (!$isLoggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>services.php">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm ms-2" href="<?php echo BASE_URL; ?>auth/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary btn-sm ms-2" href="<?php echo BASE_URL; ?>auth/signup.php">Sign Up</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>services.php">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>appointments.php">My Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>resources.php">Resources</a>
                        </li>
                        <?php if (in_array($currentUser['role'], ['admin', 'counselor', 'mentor'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>admin/">Admin</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-mdb-toggle="dropdown">
                                <span class="material-icons" style="vertical-align: middle;">account_circle</span>
                                <?php echo htmlspecialchars($currentUser['name']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>settings.php">Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>auth/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <button class="btn-theme-toggle" onclick="toggleTheme()">
                            <span class="material-icons" id="themeIcon">dark_mode</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Bottom Navigation -->
    <?php if ($isLoggedIn): ?>
    <div class="bottom-nav">
        <a href="<?php echo BASE_URL; ?>dashboard.php" class="bottom-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <span class="material-icons">home</span>
            <span>Home</span>
        </a>
        <a href="<?php echo BASE_URL; ?>services.php" class="bottom-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">
            <span class="material-icons">medical_services</span>
            <span>Services</span>
        </a>
        <a href="<?php echo BASE_URL; ?>appointments.php" class="bottom-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">
            <span class="material-icons">event</span>
            <span>Appointments</span>
        </a>
        <a href="<?php echo BASE_URL; ?>profile.php" class="bottom-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
            <span class="material-icons">person</span>
            <span>Profile</span>
        </a>
    </div>
    
    <!-- Floating Action Button -->
    <button class="fab" onclick="window.location.href='<?php echo BASE_URL; ?>book-appointment.php'">
        <span class="material-icons">add</span>
    </button>
    <?php endif; ?>
    
    <script>
        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            document.getElementById('themeIcon').textContent = newTheme === 'dark' ? 'light_mode' : 'dark_mode';
            localStorage.setItem('theme', newTheme);
        }
        
        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.getElementById('themeIcon').textContent = savedTheme === 'dark' ? 'light_mode' : 'dark_mode';
        });
    </script>
