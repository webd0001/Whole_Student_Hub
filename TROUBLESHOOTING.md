# 🔧 Troubleshooting Guide - Error 500 Fix

## ✅ Issue Fixed!

The database name mismatch has been corrected. The configuration now matches your database name: `Whole_Student_Hub`

---

## 🚀 Quick Fix Steps

### Step 1: Verify Database Name
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Check if database `Whole_Student_Hub` exists
3. If not, create it exactly as: `Whole_Student_Hub` (case-sensitive)

### Step 2: Import Schema (if not done)
1. Select the `Whole_Student_Hub` database
2. Click **Import** tab
3. Choose file: `database/schema.sql`
4. Click **Go**

### Step 3: Test Connection
Open in browser: http://localhost/Whole%20Student%20Hub/test-connection.php

This will show you:
- ✓ Configuration status
- ✓ Database connection
- ✓ Tables existence
- ✓ Admin user status

### Step 4: Access Application
If test passes, go to: http://localhost/Whole%20Student%20Hub/

---

## 🐛 Common Error 500 Causes & Solutions

### 1. Database Connection Failed

**Symptoms:**
- Error 500 on any page
- "Database connection failed" message

**Solutions:**
```
✓ Make sure MySQL is running in XAMPP Control Panel
✓ Database name must be exactly: Whole_Student_Hub
✓ Default credentials: root / (no password)
✓ Check config/database.php has correct name
```

**Verify:**
```php
// In config/database.php, line 9 should be:
define('DB_NAME', 'Whole_Student_Hub');
```

---

### 2. Database Not Created

**Symptoms:**
- "Unknown database" error
- Connection test fails

**Solution:**
1. Go to: http://localhost/phpmyadmin
2. Click **"New"** in left sidebar
3. Database name: `Whole_Student_Hub`
4. Collation: `utf8mb4_general_ci`
5. Click **"Create"**

---

### 3. Tables Not Imported

**Symptoms:**
- "Table doesn't exist" error
- Application loads but shows errors

**Solution:**
1. In phpMyAdmin, select `Whole_Student_Hub` database
2. Click **Import** tab
3. Click **"Choose File"**
4. Select: `C:\xampp\htdocs\Whole Student Hub\database\schema.sql`
5. Click **"Go"**
6. Wait for success message

**Verify Tables:**
You should see 13 tables:
- users
- password_resets
- services
- service_schedules
- appointments
- resources
- resource_downloads
- forum_posts
- forum_replies
- support_tickets
- ticket_replies
- settings

---

### 4. Apache Not Running

**Symptoms:**
- "This site can't be reached"
- Connection refused

**Solution:**
1. Open **XAMPP Control Panel**
2. Click **Start** next to Apache
3. Wait for green highlight
4. Try accessing site again

---

### 5. MySQL Not Running

**Symptoms:**
- Database connection errors
- Error 500 immediately

**Solution:**
1. Open **XAMPP Control Panel**
2. Click **Start** next to MySQL
3. Wait for green highlight
4. Test connection again

---

### 6. PHP Errors

**Symptoms:**
- Blank white page
- Error 500 with no message

**Solution:**
Check Apache error log:
```
C:\xampp\apache\logs\error.log
```

Look for the last error message for clues.

---

### 7. Upload Directory Missing

**Symptoms:**
- File upload fails
- Warnings about directories

**Solution:**
Create these folders:
```
C:\xampp\htdocs\Whole Student Hub\uploads\
C:\xampp\htdocs\Whole Student Hub\uploads\documents\
C:\xampp\htdocs\Whole Student Hub\uploads\appointments\
C:\xampp\htdocs\Whole Student Hub\uploads\resources\
C:\xampp\htdocs\Whole Student Hub\uploads\profiles\
```

---

## 🔍 Diagnostic Tools

### Tool 1: Test Connection
```
http://localhost/Whole%20Student%20Hub/test-connection.php
```
Shows detailed connection status

### Tool 2: Setup Check
```
http://localhost/Whole%20Student%20Hub/setup-check.php
```
Comprehensive installation verification

### Tool 3: PHP Info
Create file `info.php`:
```php
<?php phpinfo(); ?>
```
Access: http://localhost/Whole%20Student%20Hub/info.php

---

## ✅ Verification Checklist

Before accessing the application, verify:

- [ ] XAMPP Apache is running (green in control panel)
- [ ] XAMPP MySQL is running (green in control panel)
- [ ] Database `Whole_Student_Hub` exists in phpMyAdmin
- [ ] All 13 tables are imported
- [ ] config/database.php has correct database name
- [ ] test-connection.php shows all green checkmarks
- [ ] uploads folder and subfolders exist

---

## 🎯 Expected Results

### After Fix:
1. **Homepage loads** - http://localhost/Whole%20Student%20Hub/
2. **Login page works** - http://localhost/Whole%20Student%20Hub/auth/login.php
3. **No error 500**
4. **Can login with admin credentials**

### Admin Login:
```
Email: admin@wholestudent.com
Password: admin123
```

---

## 🔄 Fresh Start (If All Else Fails)

### Complete Reset:

1. **Delete Database:**
   - In phpMyAdmin, drop `Whole_Student_Hub` database

2. **Recreate Database:**
   - Create new database: `Whole_Student_Hub`
   - Import `schema.sql` again

3. **Clear Browser Cache:**
   - Press Ctrl+Shift+Delete
   - Clear all cached data

4. **Restart XAMPP:**
   - Stop Apache and MySQL
   - Wait 5 seconds
   - Start both again

5. **Test Again:**
   - http://localhost/Whole%20Student%20Hub/test-connection.php

---

## 📞 Still Having Issues?

### Check These:

1. **Apache Error Log:**
   ```
   C:\xampp\apache\logs\error.log
   ```

2. **PHP Error Log:**
   ```
   C:\xampp\php\logs\php_error_log
   ```

3. **MySQL Error Log:**
   ```
   C:\xampp\mysql\data\mysql_error.log
   ```

### Common Error Messages:

**"Access denied for user 'root'@'localhost'"**
- Solution: Check MySQL password in config/database.php

**"Unknown database 'whole_student_hub'"**
- Solution: Database name mismatch - use `Whole_Student_Hub`

**"Table 'users' doesn't exist"**
- Solution: Import schema.sql file

**"Cannot modify header information"**
- Solution: Check for whitespace before <?php tags

---

## 🎉 Success Indicators

Your installation is working if:

✓ Homepage loads without errors
✓ You can see the hero section and features
✓ Login page displays correctly
✓ No error 500 messages
✓ test-connection.php shows all green checks

---

## 📝 Quick Reference

### Important URLs:
```
Homepage:     http://localhost/Whole%20Student%20Hub/
Login:        http://localhost/Whole%20Student%20Hub/auth/login.php
Admin Panel:  http://localhost/Whole%20Student%20Hub/admin/
Test:         http://localhost/Whole%20Student%20Hub/test-connection.php
phpMyAdmin:   http://localhost/phpmyadmin
```

### Database Details:
```
Name:     Whole_Student_Hub
Host:     localhost
User:     root
Password: (empty)
```

### File Locations:
```
Config:   C:\xampp\htdocs\Whole Student Hub\config\database.php
Schema:   C:\xampp\htdocs\Whole Student Hub\database\schema.sql
Logs:     C:\xampp\apache\logs\error.log
```

---

## 🔐 After Fixing

Once everything works:

1. **Login as admin**
2. **Change admin password** (Profile page)
3. **Delete test files:**
   - test-connection.php
   - setup-check.php
   - info.php (if created)

---

**Last Updated:** October 28, 2025

**Status:** ✅ Database configuration fixed - Ready to test!
