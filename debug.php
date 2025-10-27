<?php
// Emergency Debug Script
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Emergency Diagnostic</h1>";
echo "<hr>";

// Test 1: PHP is working
echo "<h3>✓ PHP is working (you can see this page)</h3>";
echo "PHP Version: " . PHP_VERSION . "<br><br>";

// Test 2: Check file paths
echo "<h3>File Path Check:</h3>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Config path: " . __DIR__ . '/config/database.php' . "<br>";

if (file_exists(__DIR__ . '/config/database.php')) {
    echo "✓ database.php exists<br><br>";
} else {
    echo "✗ database.php NOT FOUND<br><br>";
    die("STOP: Config file missing!");
}

// Test 3: Try to load config
echo "<h3>Loading Configuration:</h3>";
try {
    require_once __DIR__ . '/config/database.php';
    echo "✓ Config loaded<br>";
    echo "DB_NAME = " . DB_NAME . "<br>";
    echo "DB_HOST = " . DB_HOST . "<br>";
    echo "DB_USER = " . DB_USER . "<br><br>";
} catch (Throwable $e) {
    echo "✗ ERROR loading config:<br>";
    echo "<pre style='color:red;'>" . $e->getMessage() . "</pre>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

// Test 4: Try database connection
echo "<h3>Database Connection Test:</h3>";
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✓ <strong style='color:green;'>CONNECTED TO DATABASE!</strong><br><br>";
    
    // Test 5: Check tables
    echo "<h3>Checking Tables:</h3>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "✓ Found " . count($tables) . " tables:<br>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
    } else {
        echo "✗ <strong style='color:red;'>NO TABLES FOUND!</strong><br>";
        echo "You need to import schema.sql<br>";
    }
    
} catch (PDOException $e) {
    echo "✗ <strong style='color:red;'>DATABASE CONNECTION FAILED!</strong><br><br>";
    echo "<strong>Error Message:</strong><br>";
    echo "<pre style='color:red; background:#ffe6e6; padding:10px;'>" . $e->getMessage() . "</pre>";
    
    echo "<h3>Possible Causes:</h3>";
    echo "<ol>";
    echo "<li>MySQL is not running in XAMPP</li>";
    echo "<li>Database 'Whole_Student_Hub' doesn't exist</li>";
    echo "<li>Wrong database credentials</li>";
    echo "</ol>";
    
    echo "<h3>What to do:</h3>";
    echo "<ol>";
    echo "<li>Open XAMPP Control Panel</li>";
    echo "<li>Make sure MySQL is running (green)</li>";
    echo "<li>Go to <a href='http://localhost/phpmyadmin' target='_blank'>phpMyAdmin</a></li>";
    echo "<li>Check if database 'Whole_Student_Hub' exists</li>";
    echo "<li>If not, create it and import schema.sql</li>";
    echo "</ol>";
    die();
}

echo "<hr>";
echo "<h2 style='color:green;'>✓ ALL TESTS PASSED!</h2>";
echo "<p>Database is working. Now let's test the actual application...</p>";

// Test 6: Try loading index.php
echo "<h3>Testing Application Load:</h3>";
try {
    ob_start();
    include __DIR__ . '/config/config.php';
    ob_end_clean();
    echo "✓ config.php loaded successfully<br>";
} catch (Throwable $e) {
    echo "✗ Error in config.php:<br>";
    echo "<pre style='color:red;'>" . $e->getMessage() . "</pre>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<h3>Next Steps:</h3>";
echo "<a href='index.php' style='display:inline-block; padding:10px 20px; background:#1976d2; color:white; text-decoration:none; border-radius:5px; margin:5px;'>Try Homepage</a>";
echo "<a href='auth/login.php' style='display:inline-block; padding:10px 20px; background:#2e7d32; color:white; text-decoration:none; border-radius:5px; margin:5px;'>Try Login Page</a>";
?>
