# Whole Student Hub 🎓

A comprehensive digital portal for student well-being, academic guidance, mentoring, and resource access — built to feel like a modern, mobile-first digital campus companion.

## 🌟 Features

### User Side (Frontend)
- **Authentication System**
  - Signup / Login with role selection (Student / Mentor / Counselor)
  - Password reset functionality
  - User profile management

- **Main Pages**
  - Responsive landing page with hero section
  - Personalized dashboard based on user role
  - Service listing with filters (category, mode, search)
  - Detailed service pages with booking options

- **Appointment Management**
  - Book appointments with service selection
  - Upload supporting documents
  - Track appointment status (Pending / Accepted / Ongoing / Completed)
  - Cancel or reschedule appointments
  - View appointment history

- **Resource Library**
  - Browse and download study materials, guides, and resources
  - Category-based filtering (Well-being / Academic / Career)
  - Secure file downloads with tracking
  - Role-based access control

- **Support System**
  - Contact forms for general queries
  - Support ticket system
  - FAQ page (searchable)

### Admin Side (Backend)
- **Dashboard**
  - Overview statistics (students, appointments, services)
  - Recent activity monitoring
  - Quick access to key functions

- **Service Management**
  - Add/Edit/Delete support services
  - Assign counselors/mentors to services
  - Manage availability and schedules

- **Appointment Management**
  - View all student requests
  - Accept/Reject/Reschedule appointments
  - Update appointment status
  - Add meeting links and notes

- **User Management**
  - View all registered users
  - Block/Unblock accounts
  - View user history and activity

- **Resource Management**
  - Upload digital resources (PDFs, documents, images)
  - Set visibility and access permissions
  - Track download metrics

- **Reports & Analytics**
  - Service usage statistics
  - Appointment trends
  - User engagement metrics

## 🛠️ Tech Stack

- **Frontend**: PHP with mdBootstrap (Material Design)
- **Backend**: PHP (Modular structure)
- **Database**: MySQL
- **UI Framework**: Material Design Bootstrap 6.4.2
- **Icons**: Material Icons
- **Fonts**: Google Fonts (Inter)

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- XAMPP/WAMP/LAMP (recommended for local development)

## 🚀 Installation

1. **Clone or Download the Project**
   ```bash
   # Place the project in your web server directory
   # For XAMPP: C:\xampp\htdocs\Whole Student Hub
   ```

2. **Create Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `whole_student_hub`
   - Import the schema:
     ```sql
     # Run the SQL file located at:
     database/schema.sql
     ```

3. **Configure Database Connection**
   - Open `config/database.php`
   - Update credentials if needed:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'whole_student_hub');
     ```

4. **Set Base URL**
   - Open `config/config.php`
   - Update BASE_URL if needed:
     ```php
     define('BASE_URL', 'http://localhost/Whole%20Student%20Hub/');
     ```

5. **Create Upload Directories**
   ```bash
   mkdir uploads
   mkdir uploads/documents
   mkdir uploads/appointments
   mkdir uploads/resources
   mkdir uploads/profiles
   ```

6. **Set Permissions** (Linux/Mac)
   ```bash
   chmod -R 755 uploads/
   ```

## 🔐 Default Admin Credentials

- **Email**: admin@wholestudent.com
- **Password**: admin123

**⚠️ Important**: Change the default admin password immediately after first login!

## 📱 Mobile-First Design

The platform is built with a mobile-first approach:
- **Mobile**: Bottom navigation bar, FAB for quick actions
- **Tablet**: Optimized layouts with responsive grids
- **Desktop**: Full sidebar navigation, multi-column layouts

## 🎨 Theme Support

- Light mode (default)
- Dark mode toggle
- Theme preference saved in localStorage

## 📂 Project Structure

```
Whole Student Hub/
├── admin/                  # Admin panel
│   ├── header.php
│   ├── footer.php
│   ├── index.php          # Admin dashboard
│   └── ...
├── auth/                   # Authentication
│   ├── login.php
│   ├── signup.php
│   └── logout.php
├── config/                 # Configuration
│   ├── config.php         # Global config
│   └── database.php       # Database connection
├── database/              # Database files
│   └── schema.sql         # Database schema
├── includes/              # Shared components
│   ├── header.php
│   └── footer.php
├── uploads/               # File uploads
├── index.php              # Landing page
├── dashboard.php          # User dashboard
├── services.php           # Service listing
├── service-detail.php     # Service details
├── book-appointment.php   # Appointment booking
├── appointments.php       # Appointment management
├── resources.php          # Resource library
├── profile.php            # User profile
└── README.md
```

## 🔧 Configuration Options

### File Upload Settings
Edit `config/config.php`:
```php
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_EXTENSIONS', ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif']);
```

### Timezone
```php
date_default_timezone_set('Asia/Kolkata');
```

## 🌐 Key Features Explained

### Role-Based Access Control
- **Student**: Access services, book appointments, download resources
- **Mentor/Counselor**: Manage appointments, provide support
- **Admin**: Full system control, user management, analytics

### Appointment Workflow
1. Student browses services
2. Books appointment with details
3. Admin/Staff reviews request
4. Appointment accepted/scheduled
5. Session conducted
6. Status marked as completed

### Resource Access Control
- **Public**: Anyone can access
- **Members**: Logged-in users only
- **Role-based**: Specific roles (e.g., only students)

## 🔒 Security Features

- Password hashing with PHP's `password_hash()`
- SQL injection prevention with prepared statements
- XSS protection with `htmlspecialchars()`
- Session-based authentication
- File upload validation
- Role-based access control

## 📊 Database Tables

- `users` - User accounts
- `services` - Support services
- `appointments` - Appointment requests
- `resources` - Digital resources
- `resource_downloads` - Download tracking
- `support_tickets` - Help tickets
- `forum_posts` - Community forum
- `settings` - Platform settings

## 🎯 Usage

### For Students
1. Sign up with student role
2. Browse available services
3. Book appointments
4. Access resources
5. Track appointment status

### For Mentors/Counselors
1. Sign up with appropriate role
2. Access admin panel
3. Review appointment requests
4. Accept and schedule sessions
5. Provide support and guidance

### For Administrators
1. Login with admin credentials
2. Manage services and users
3. Upload resources
4. Monitor platform activity
5. Generate reports

## 🐛 Troubleshooting

### Database Connection Error
- Check database credentials in `config/database.php`
- Ensure MySQL service is running
- Verify database exists

### File Upload Issues
- Check upload directory permissions
- Verify `MAX_FILE_SIZE` in php.ini
- Ensure `uploads/` directory exists

### Session Issues
- Check PHP session configuration
- Ensure cookies are enabled
- Clear browser cache

## 📝 Future Enhancements

- Email notifications (PHPMailer integration)
- Real-time chat between students and counselors
- Calendar integration for appointments
- Mobile app (React Native/Flutter)
- Payment gateway for paid services
- Video conferencing integration
- Advanced analytics dashboard
- Multi-language support

## 👥 Support

For issues or questions:
- Email: support@wholestudent.com
- Create a support ticket in the platform
- Check FAQ section

## 📄 License

This project is developed for educational and institutional use.

## 🙏 Acknowledgments

- Material Design Bootstrap for UI components
- Google Material Icons
- Inter font family

---

**Built with ❤️ for student success and well-being**
