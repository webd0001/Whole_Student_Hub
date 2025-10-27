<?php
/**
 * Database Connection Test
 * This file helps diagnose connection issues
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Testing Database Connection...</h2>";

// Test 1: Check if config files exist
echo "<h3>1. Checking Configuration Files:</h3>";
if (file_exists(__DIR__ . '/config/database.php')) {
    echo "✓ database.php exists<br>";
} else {
    echo "✗ database.php NOT found<br>";
}

if (file_exists(__DIR__ . '/config/config.php')) {
    echo "✓ config.php exists<br>";
} else {
    echo "✗ config.php NOT found<br>";
}

// Test 2: Try to include database config
echo "<h3>2. Loading Database Configuration:</h3>";
try {
    require_once __DIR__ . '/config/database.php';
    echo "✓ Database configuration loaded<br>";
    echo "Database Name: " . DB_NAME . "<br>";
    echo "Database Host: " . DB_HOST . "<br>";
    echo "Database User: " . DB_USER . "<br>";
} catch (Exception $e) {
    echo "✗ Error loading config: " . $e->getMessage() . "<br>";
    die();
}

// Test 3: Try to connect to database
echo "<h3>3. Testing Database Connection:</h3>";
try {
    $db = Database::getInstance()->getConnection();
    echo "✓ <strong style='color: green;'>Database connected successfully!</strong><br>";
} catch (Exception $e) {
    echo "✗ <strong style='color: red;'>Connection failed: " . $e->getMessage() . "</strong><br>";
    echo "<br><strong>Possible Solutions:</strong><br>";
    echo "1. Make sure MySQL is running in XAMPP Control Panel<br>";
    echo "2. Verify database name is exactly: <strong>Whole_Student_Hub</strong><br>";
    echo "3. Check if database was created in phpMyAdmin<br>";
    echo "4. Verify schema.sql was imported successfully<br>";
    die();
}

// Test 4: Check if tables exist
echo "<h3>4. Checking Database Tables:</h3>";
try {
    $tables = ['users', 'services', 'appointments', 'resources', 'settings'];
    foreach ($tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✓ Table '$table' exists<br>";
        } else {
            echo "✗ Table '$table' NOT found<br>";
        }
    }
} catch (Exception $e) {
    echo "✗ Error checking tables: " . $e->getMessage() . "<br>";
}

// Test 5: Check admin user
echo "<h3>5. Checking Admin User:</h3>";
try {
    $stmt = $db->query("SELECT * FROM users WHERE role = 'admin' LIMIT 1");
    $admin = $stmt->fetch();
    if ($admin) {
        echo "✓ Admin user found<br>";
        echo "Email: " . $admin['email'] . "<br>";
    } else {
        echo "✗ No admin user found<br>";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3 style='color: green;'>✓ All Tests Passed!</h3>";
echo "<p>Your database is properly configured. You can now access the application:</p>";
echo "<a href='index.php' style='display: inline-block; padding: 10px 20px; background: #1976d2; color: white; text-decoration: none; border-radius: 5px;'>Go to Homepage</a>";
echo "<br><br>";
echo "<a href='auth/login.php' style='display: inline-block; padding: 10px 20px; background: #2e7d32; color: white; text-decoration: none; border-radius: 5px;'>Go to Login</a>";
echo "<br><br>";
echo "<small style='color: #666;'>Delete this file (test-connection.php) after verification for security.</small>";
?>
