-- Whole Student Hub Database Schema
-- Drop existing tables if they exist
DROP TABLE IF EXISTS ticket_replies;
DROP TABLE IF EXISTS support_tickets;
DROP TABLE IF EXISTS forum_replies;
DROP TABLE IF EXISTS forum_posts;
DROP TABLE IF EXISTS resource_downloads;
DROP TABLE IF EXISTS resources;
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS service_schedules;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS password_resets;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS settings;

-- Users table (Students, Mentors, Counselors, Admins)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'mentor', 'counselor', 'admin') DEFAULT 'student',
    profile_picture VARCHAR(255) DEFAULT NULL,
    department VARCHAR(100) DEFAULT NULL,
    academic_year VARCHAR(50) DEFAULT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    is_blocked BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password reset tokens
CREATE TABLE password_resets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_token (token),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Services (Counseling, Tutoring, Workshops, etc.)
CREATE TABLE services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category ENUM('academic', 'counseling', 'career', 'mentorship', 'workshop', 'other') NOT NULL,
    mode ENUM('online', 'offline', 'both') DEFAULT 'both',
    urgency_level ENUM('low', 'medium', 'high') DEFAULT 'medium',
    assigned_staff_id INT DEFAULT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    image VARCHAR(255) DEFAULT NULL,
    duration_minutes INT DEFAULT 60,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_staff_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_category (category),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Service schedules (availability slots)
CREATE TABLE service_schedules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    service_id INT NOT NULL,
    staff_id INT NOT NULL,
    day_of_week ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_service (service_id),
    INDEX idx_staff (staff_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Appointments / Support Requests
CREATE TABLE appointments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    service_id INT NOT NULL,
    staff_id INT DEFAULT NULL,
    category ENUM('academic', 'emotional', 'career', 'mentorship', 'other') NOT NULL,
    mode ENUM('online', 'in-person') NOT NULL,
    description TEXT NOT NULL,
    document_path VARCHAR(255) DEFAULT NULL,
    appointment_date DATE DEFAULT NULL,
    appointment_time TIME DEFAULT NULL,
    status ENUM('pending', 'accepted', 'ongoing', 'completed', 'cancelled', 'rejected') DEFAULT 'pending',
    meeting_link VARCHAR(255) DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_student (student_id),
    INDEX idx_status (status),
    INDEX idx_date (appointment_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Resources (PDFs, videos, guides)
CREATE TABLE resources (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    category ENUM('wellbeing', 'academic', 'career', 'general') NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    file_size INT DEFAULT NULL,
    audience ENUM('all', 'freshman', 'sophomore', 'junior', 'senior', 'graduate') DEFAULT 'all',
    visibility ENUM('public', 'members', 'role-based') DEFAULT 'members',
    allowed_roles VARCHAR(100) DEFAULT NULL,
    download_count INT DEFAULT 0,
    uploaded_by INT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    expires_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_category (category),
    INDEX idx_visibility (visibility)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Resource downloads tracking
CREATE TABLE resource_downloads (
    id INT PRIMARY KEY AUTO_INCREMENT,
    resource_id INT NOT NULL,
    user_id INT NOT NULL,
    download_token VARCHAR(255) DEFAULT NULL,
    downloaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (resource_id) REFERENCES resources(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_resource (resource_id),
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Community Forum Posts
CREATE TABLE forum_posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category ENUM('academic', 'wellbeing', 'career', 'general') DEFAULT 'general',
    is_approved BOOLEAN DEFAULT FALSE,
    is_pinned BOOLEAN DEFAULT FALSE,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_category (category),
    INDEX idx_approved (is_approved)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Forum Replies
CREATE TABLE forum_replies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    is_approved BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES forum_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_post (post_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Support Tickets
CREATE TABLE support_tickets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    category ENUM('technical', 'counseling', 'general', 'feedback') DEFAULT 'general',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('open', 'assigned', 'in-progress', 'resolved', 'closed') DEFAULT 'open',
    assigned_to INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Ticket Replies
CREATE TABLE ticket_replies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ticket_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_staff_reply BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES support_tickets(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_ticket (ticket_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Platform Settings
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT NOT NULL,
    setting_type ENUM('text', 'boolean', 'number', 'json') DEFAULT 'text',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (password: admin123)
INSERT INTO users (name, email, password, role) VALUES 
('Admin User', 'admin@wholestudent.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert default settings
INSERT INTO settings (setting_key, setting_value, setting_type) VALUES
('site_name', 'Whole Student Hub', 'text'),
('site_logo', 'assets/images/logo.png', 'text'),
('theme_mode', 'light', 'text'),
('enable_forum', 'true', 'boolean'),
('enable_chatbot', 'false', 'boolean'),
('email_notifications', 'true', 'boolean'),
('max_file_size', '5242880', 'number');

-- Insert sample services
INSERT INTO services (title, description, category, mode, assigned_staff_id) VALUES
('Academic Tutoring', 'One-on-one tutoring sessions for various subjects', 'academic', 'both', NULL),
('Mental Health Counseling', 'Confidential counseling sessions for emotional support', 'counseling', 'both', NULL),
('Career Guidance', 'Career planning and job search assistance', 'career', 'online', NULL),
('Peer Mentorship', 'Connect with senior students for guidance', 'mentorship', 'both', NULL),
('Study Skills Workshop', 'Learn effective study techniques and time management', 'workshop', 'offline', NULL);
