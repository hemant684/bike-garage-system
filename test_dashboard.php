<?php
/**
 * Admin Dashboard Test Script
 * Bike Garage Management System
 */

echo "<h1>🧪 Admin Dashboard Test</h1>";

// Test 1: Database Connection
echo "<h2>Test 1: Database Connection</h2>";
try {
    $socket = '/Applications/MAMP/tmp/mysql/mysql.sock';
    $conn = new mysqli('localhost', 'root', 'root', 'bike_garage', 8889, $socket);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<p style='color: green;'>✅ Database connected successfully</p>";
    echo "<p>Server Info: " . $conn->server_info . "</p>";
    
    // Set charset
    $conn->set_charset("utf8mb4");
    echo "<p style='color: green;'>✅ Charset set to utf8mb4</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database Error: " . $e->getMessage() . "</p>";
    exit;
}

// Test 2: Check Admin User
echo "<h2>Test 2: Admin User Check</h2>";
$result = $conn->query("SELECT id, username, email, full_name, role, status FROM admin");
if ($result && $result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    echo "<p style='color: green;'>✅ Admin user found:</p>";
    echo "<ul>";
    echo "<li>Username: " . htmlspecialchars($admin['username']) . "</li>";
    echo "<li>Email: " . htmlspecialchars($admin['email']) . "</li>";
    echo "<li>Role: " . htmlspecialchars($admin['role']) . "</li>";
    echo "<li>Status: " . htmlspecialchars($admin['status']) . "</li>";
    echo "</ul>";
    
    // Test password
    $testPassword = 'admin123';
    if (password_verify($testPassword, $admin['password'])) {
        echo "<p style='color: green;'>✅ Password verification: CORRECT</p>";
    } else {
        echo "<p style='color: red;'>❌ Password verification: FAILED</p>";
        // Reset password
        $hashed = password_hash($testPassword, PASSWORD_DEFAULT);
        $conn->query("UPDATE admin SET password = '$hashed' WHERE id = " . $admin['id']);
        echo "<p style='color: orange;'>⚠️ Password has been reset to: $testPassword</p>";
    }
} else {
    echo "<p style='color: red;'>❌ No admin user found!</p>";
}

// Test 3: Check Required Tables
echo "<h2>Test 3: Required Tables</h2>";
$requiredTables = ['users', 'service_booking', 'billing', 'admin'];
foreach ($requiredTables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        // Get count
        $countResult = $conn->query("SELECT COUNT(*) as cnt FROM $table");
        $count = $countResult->fetch_assoc()['cnt'];
        echo "<p style='color: green;'>✅ Table '$table': $count records</p>";
    } else {
        echo "<p style='color: red;'>❌ Table '$table' missing!</p>";
    }
}

// Test 4: Session Configuration
echo "<h2>Test 4: Session Configuration</h2>";
session_start();
echo "<p style='color: green;'>✅ Session started successfully</p>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . session_status() . "</p>";

// Test 5: Test Dashboard Logic
echo "<h2>Test 5: Dashboard Logic Test</h2>";

// Simulate admin login
$admin = $result->fetch_assoc() ?? [];
if (!empty($admin)) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['username'];
    $_SESSION['admin_name'] = $admin['full_name'];
    $_SESSION['admin_email'] = $admin['email'];
    $_SESSION['admin_role'] = $admin['role'];
    $_SESSION['admin_login_time'] = time();
    $_SESSION['last_activity'] = time();
    $_SESSION['admin_type'] = 'admin';
    
    echo "<p style='color: green;'>✅ Session variables set for admin</p>";
    
    // Test dashboard queries (without displaying)
    $queries = [
        "SELECT COUNT(*) as total FROM users" => "Users count",
        "SELECT COUNT(*) as total FROM service_booking" => "Bookings count",
        "SELECT COUNT(*) as total FROM service_booking WHERE status = 'pending'" => "Pending services",
        "SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE payment_status = 'paid'" => "Total revenue"
    ];
    
    foreach ($queries as $query => $label) {
        $result = $conn->query($query);
        if ($result) {
            $data = $result->fetch_assoc();
            echo "<p style='color: green;'>✅ $label: " . $data['total'] . "</p>";
        } else {
            echo "<p style='color: red;'>❌ $label query failed</p>";
        }
    }
}

// Test 6: File Paths
echo "<h2>Test 6: File Paths Check</h2>";
$files = [
    'config/db_config.php',
    'config/session.php', 
    'config/functions.php',
    'admin/admin_login.php',
    'admin/admin_dashboard.php',
    'css/style.css'
];

foreach ($files as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "<p style='color: green;'>✅ $file exists</p>";
    } else {
        echo "<p style='color: red;'>❌ $file missing!</p>";
    }
}

echo "<h2>🎉 Test Complete!</h2>";
echo "<div style='background: #1e1e1e; padding: 20px; border-radius: 10px; margin-top: 20px;'>";
echo "<h3>Login Credentials:</h3>";
echo "<p><strong>Username:</strong> admin</p>";
echo "<p><strong>Password:</strong> admin123</p>";
echo "<h3>Access URLs:</h3>";
echo "<p><strong>Admin Login:</strong> <a href='admin/admin_login.php' style='color: #00b4d8;'>admin/admin_login.php</a></p>";
echo "<p><strong>Admin Dashboard:</strong> <a href='admin/admin_dashboard.php' style='color: #00b4d8;'>admin/admin_dashboard.php</a></p>";
echo "</div>";

$conn->close();
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 900px;
    margin: 50px auto;
    padding: 20px;
    background: #0d0d0d;
    color: #fff;
}
h1 { color: #e63946; }
h2 { color: #00b4d8; margin-top: 30px; border-bottom: 1px solid #333; padding-bottom: 10px; }
p { margin: 8px 0; }
a { color: #00b4d8; }
</style>
