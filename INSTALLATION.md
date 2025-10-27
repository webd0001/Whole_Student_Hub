# Installation Guide - Whole Student Hub

## Quick Start Guide

Follow these steps to get the Whole Student Hub up and running on your local machine.

### Prerequisites

- **XAMPP** (or any PHP development environment)
  - PHP 7.4 or higher
  - MySQL 5.7 or higher
  - Apache Web Server

### Step-by-Step Installation

#### 1. Download and Setup XAMPP

1. Download XAMPP from [https://www.apachefriends.org](https://www.apachefriends.org)
2. Install XAMPP to `C:\xampp` (default location)
3. Start Apache and MySQL from XAMPP Control Panel

#### 2. Place Project Files

The project is already in the correct location:
```
C:\xampp\htdocs\Whole Student Hub\
```

#### 3. Create Database

1. Open your web browser and go to: `http://localhost/phpmyadmin`
2. Click on "New" in the left sidebar
3. Create a new database named: `whole_student_hub`
4. Select the database
5. Click on "Import" tab
6. Click "Choose File" and select: `C:\xampp\htdocs\Whole Student Hub\database\schema.sql`
7. Click "Go" to import the database

#### 4. Configure Database Connection (Optional)

If you're using custom MySQL credentials, edit the file:
```
C:\xampp\htdocs\Whole Student Hub\config\database.php
```

Update these lines if needed:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Default XAMPP has no password
define('DB_NAME', 'whole_student_hub');
```

#### 5. Create Upload Directories

The following directories need to exist for file uploads:

1. Navigate to: `C:\xampp\htdocs\Whole Student Hub\`
2. Create a folder named `uploads`
3. Inside `uploads`, create these subfolders:
   - `documents`
   - `appointments`
   - `resources`
   - `profiles`

Your structure should look like:
```
Whole Student Hub/
├── uploads/
│   ├── documents/
│   ├── appointments/
│   ├── resources/
│   └── profiles/
```

#### 6. Access the Application

Open your web browser and navigate to:
```
http://localhost/Whole%20Student%20Hub/
```

Or simply:
```
http://localhost/Whole Student Hub/
```

### Default Login Credentials

#### Admin Account
- **Email**: `admin@wholestudent.com`
- **Password**: `admin123`

**⚠️ IMPORTANT**: Change the admin password immediately after first login!

### Testing the Installation

1. **Homepage**: Visit `http://localhost/Whole Student Hub/`
   - You should see the landing page with hero section

2. **Sign Up**: Click "Sign Up" and create a student account
   - Fill in all required fields
   - Select "Student" as role

3. **Login**: Login with your new account
   - You should be redirected to the dashboard

4. **Admin Panel**: Login with admin credentials
   - Go to `http://localhost/Whole Student Hub/admin/`
   - You should see the admin dashboard

### Common Issues and Solutions

#### Issue: "Database connection failed"
**Solution**: 
- Make sure MySQL is running in XAMPP Control Panel
- Verify database name is `whole_student_hub`
- Check credentials in `config/database.php`

#### Issue: "Page not found" or 404 errors
**Solution**:
- Ensure Apache is running in XAMPP
- Check that files are in `C:\xampp\htdocs\Whole Student Hub\`
- Try accessing: `http://localhost/Whole%20Student%20Hub/`

#### Issue: File upload errors
**Solution**:
- Make sure `uploads` folder exists
- Check folder permissions (should be writable)
- Verify `upload_max_filesize` in `php.ini` (default is usually fine)

#### Issue: Session errors
**Solution**:
- Clear browser cookies and cache
- Restart Apache in XAMPP
- Check that `session.save_path` is writable in `php.ini`

### Next Steps

1. **Change Admin Password**
   - Login as admin
   - Go to Profile
   - Update password

2. **Add Services**
   - Go to Admin Panel → Services
   - Add your institution's support services

3. **Create Staff Accounts**
   - Register counselors and mentors
   - Assign them to services

4. **Upload Resources**
   - Go to Admin Panel → Resources
   - Upload study materials and guides

5. **Customize Settings**
   - Update site name and branding
   - Configure email notifications (requires PHPMailer setup)

### File Structure Overview

```
Whole Student Hub/
├── admin/              # Admin panel files
├── auth/               # Authentication (login, signup, logout)
├── config/             # Configuration files
├── database/           # Database schema
├── includes/           # Shared components (header, footer)
├── uploads/            # User uploaded files
├── index.php           # Landing page
├── dashboard.php       # User dashboard
├── services.php        # Service listing
├── appointments.php    # Appointment management
├── resources.php       # Resource library
├── profile.php         # User profile
├── README.md           # Project documentation
└── INSTALLATION.md     # This file
```

### Security Recommendations

1. **Change Default Credentials**
   - Update admin password immediately
   - Use strong passwords

2. **Production Deployment**
   - Disable error display in `config/config.php`
   - Use HTTPS (SSL certificate)
   - Set proper file permissions
   - Enable MySQL password protection

3. **Regular Backups**
   - Backup database regularly
   - Backup uploaded files in `uploads/` folder

### Support

If you encounter any issues:

1. Check the FAQ page in the application
2. Review this installation guide
3. Check XAMPP error logs at: `C:\xampp\apache\logs\error.log`
4. Verify PHP version: Create a file `info.php` with `<?php phpinfo(); ?>` and access it

### Development Tips

- **Enable Error Reporting**: Already enabled in `config/config.php` for development
- **Database Changes**: Always update `database/schema.sql` when making schema changes
- **Testing**: Test on different browsers and devices
- **Mobile View**: Use browser dev tools to test responsive design

---

**Congratulations!** 🎉 Your Whole Student Hub is now ready to use!

For more information, see the main README.md file.
