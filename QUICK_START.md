# 🚀 Quick Start Guide - Whole Student Hub

Get up and running in **5 minutes**!

---

## ⚡ Super Quick Setup (3 Steps)

### Step 1: Start XAMPP
1. Open **XAMPP Control Panel**
2. Click **Start** for **Apache**
3. Click **Start** for **MySQL**

### Step 2: Create Database
1. Go to: http://localhost/phpmyadmin
2. Click **"New"** → Database name: `whole_student_hub`
3. Click **"Import"** → Choose file: `database/schema.sql`
4. Click **"Go"**

### Step 3: Access Application
Open browser: http://localhost/Whole%20Student%20Hub/

**Done!** 🎉

---

## 📋 First Time Login

### Admin Access
```
Email: admin@wholestudent.com
Password: admin123
```

### Create Student Account
1. Click **"Sign Up"**
2. Fill in details
3. Select role: **Student**
4. Click **"Create Account"**

---

## ✅ Verify Installation

Run setup check: http://localhost/Whole%20Student%20Hub/setup-check.php

This will verify:
- ✓ Database connection
- ✓ Required tables
- ✓ Upload directories
- ✓ PHP configuration

---

## 🎯 What to Do Next

### 1. Change Admin Password
- Login as admin
- Go to **Profile**
- Update password

### 2. Add Services
- Admin Panel → **Services**
- Click **"Add New Service"**
- Fill in details

### 3. Create Staff Accounts
- Sign up as **Mentor** or **Counselor**
- Admin can assign to services

### 4. Upload Resources
- Admin Panel → **Resources**
- Upload study materials
- Set visibility

### 5. Test Booking
- Login as student
- Browse **Services**
- Click **"Book Appointment"**
- Fill form and submit

---

## 📁 Important Directories

### Must Create (for file uploads):
```
uploads/
├── documents/
├── appointments/
├── resources/
└── profiles/
```

**How to create:**
1. Navigate to: `C:\xampp\htdocs\Whole Student Hub\`
2. Create folder: `uploads`
3. Inside uploads, create 4 subfolders above

---

## 🔧 Common Issues

### "Database connection failed"
**Fix:** Make sure MySQL is running in XAMPP

### "Page not found"
**Fix:** Check URL is: http://localhost/Whole%20Student%20Hub/

### "Upload failed"
**Fix:** Create `uploads` folder and subfolders

### "Session error"
**Fix:** Restart Apache in XAMPP

---

## 🌐 Main URLs

| Page | URL |
|------|-----|
| Homepage | http://localhost/Whole%20Student%20Hub/ |
| Login | http://localhost/Whole%20Student%20Hub/auth/login.php |
| Sign Up | http://localhost/Whole%20Student%20Hub/auth/signup.php |
| Dashboard | http://localhost/Whole%20Student%20Hub/dashboard.php |
| Admin Panel | http://localhost/Whole%20Student%20Hub/admin/ |
| Setup Check | http://localhost/Whole%20Student%20Hub/setup-check.php |

---

## 📱 Test Features

### As Student:
1. ✓ Browse services
2. ✓ Book appointment
3. ✓ View appointments
4. ✓ Download resources
5. ✓ Update profile

### As Admin:
1. ✓ View dashboard
2. ✓ Manage appointments
3. ✓ Accept/Reject requests
4. ✓ Add meeting links
5. ✓ Upload resources

---

## 🎨 Features to Explore

### Mobile View
- Resize browser to mobile size
- See bottom navigation
- Test floating action button

### Dark Mode
- Click moon icon in navbar
- Toggle between light/dark
- Preference is saved

### Filters
- Try service filters (category, mode)
- Test appointment status filters
- Search resources

---

## 📊 Sample Data Included

### Services (5 pre-loaded):
1. Academic Tutoring
2. Mental Health Counseling
3. Career Guidance
4. Peer Mentorship
5. Study Skills Workshop

### Users:
- 1 Admin account (see credentials above)

### Settings:
- Site name: Whole Student Hub
- Theme: Light mode
- Max file size: 5MB

---

## 🔐 Security Checklist

- [ ] Change admin password
- [ ] Create strong passwords
- [ ] Delete `setup-check.php` after verification
- [ ] Review user permissions
- [ ] Test file upload limits

---

## 📚 Documentation

| Document | Purpose |
|----------|---------|
| README.md | Full project documentation |
| INSTALLATION.md | Detailed installation guide |
| PROJECT_SUMMARY.md | Feature overview |
| QUICK_START.md | This file |

---

## 🆘 Need Help?

### Check These First:
1. **FAQ Page** - In the application
2. **INSTALLATION.md** - Detailed setup guide
3. **Error Logs** - `C:\xampp\apache\logs\error.log`

### Test Database Connection:
Create file `test-db.php`:
```php
<?php
require_once 'config/database.php';
try {
    $db = Database::getInstance()->getConnection();
    echo "✓ Database connected successfully!";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage();
}
?>
```

---

## 🎓 User Roles Explained

### Student
- Book appointments
- Access resources
- View appointment history
- Update profile

### Mentor/Counselor
- View assigned appointments
- Accept/reject requests
- Add meeting links
- Provide support

### Admin
- Full system access
- Manage all users
- Configure services
- Upload resources
- View analytics

---

## 🔄 Typical Workflow

```
Student Journey:
1. Sign up → 2. Browse services → 3. Book appointment
→ 4. Wait for approval → 5. Attend session → 6. Mark complete

Admin Journey:
1. Login → 2. View pending requests → 3. Review details
→ 4. Accept & schedule → 5. Add meeting link → 6. Mark complete
```

---

## ⚙️ Configuration

### Database (config/database.php):
```php
DB_HOST: localhost
DB_USER: root
DB_PASS: (empty for XAMPP)
DB_NAME: whole_student_hub
```

### Upload Limits (config/config.php):
```php
MAX_FILE_SIZE: 5MB
ALLOWED_EXTENSIONS: pdf, doc, docx, jpg, jpeg, png, gif
```

### Timezone:
```php
Asia/Kolkata (can be changed in config/config.php)
```

---

## 🎯 Success Indicators

Your installation is successful if:
- ✓ Homepage loads without errors
- ✓ You can login as admin
- ✓ Dashboard shows statistics
- ✓ Services page displays 5 services
- ✓ You can create a student account
- ✓ Appointment booking works

---

## 🚀 Production Deployment

Before going live:
1. Change all default passwords
2. Disable error display
3. Enable HTTPS
4. Set up email notifications
5. Configure backups
6. Review security settings
7. Test on multiple devices

---

## 📞 Support

For issues not covered here:
- Review full documentation in README.md
- Check INSTALLATION.md for detailed steps
- Verify setup with setup-check.php

---

## 🎉 You're All Set!

Your Whole Student Hub is ready to use. Start by:
1. Logging in as admin
2. Exploring the dashboard
3. Creating a test appointment
4. Trying different features

**Enjoy your new student support platform!** 🎓

---

*Last Updated: October 28, 2025*
*Version: 1.0.0*
