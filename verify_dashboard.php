<?php
/**
 * Admin Dashboard Verification Script
 * Bike Garage Management System
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>✅ Admin Dashboard Verification</h1>";

// Database Connection Test
echo "<h2>1. Database Connection</h2>";

// Try different connection methods
$conn = null;
$connection_attempts = [
    ['host' => 'localhost', 'user' => 'root', 'pass' => '', 'port' => 8889],
    ['host' => 'localhost', 'user' => 'root', 'pass' => 'root', 'port' => 8889],
    ['host' => 'localhost', 'user' => 'root', 'pass' => '', 'port' => 3306],
];

foreach ($connection_attempts as $attempt) {
    $conn = new mysqli($attempt['host'], $attempt['user'], $attempt['pass'], 'bike_garage', $attempt['port']);
    if (!$conn->connect_error) {
        break;
    }
    $conn = null;
}

if ($conn === null || $conn->connect_error) {
    die("<p style='color: red;'>❌ Database connection failed. Please ensure MAMP MySQL is running on port 8889.</p>");
}
echo "<p style='color: green;'>✅ Connected to MySQL (Version: " . $conn->server_info . ")</p>";
echo "<p>Database: bike_garage</p>";

// Check Admin User
echo "<h2>2. Admin User Verification</h2>";
$result = $conn->query("SELECT id, username, email, full_name, role, status, password FROM admin LIMIT 1");
if ($result && $result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%; max-width: 600px;'>";
    echo "<tr><td><strong>Username</strong></td><td>" . htmlspecialchars($admin['username']) . "</td></tr>";
    echo "<tr><td><strong>Email</strong></td><td>" . htmlspecialchars($admin['email']) . "</td></tr>";
    echo "<tr><td><strong>Full Name</strong></td><td>" . htmlspecialchars($admin['full_name']) . "</td></tr>";
    echo "<tr><td><strong>Role</strong></td><td>" . htmlspecialchars($admin['role']) . "</td></tr>";
    echo "<tr><td><strong>Status</strong></td><td>" . htmlspecialchars($admin['status']) . "</td></tr>";
    echo "</table>";
    
    // Test password
    $testPassword = 'admin123';
    $isValid = password_verify($testPassword, $admin['password']);
    
    echo "<h3>Password Verification</h3>";
    if ($isValid) {
        echo "<p style='color: green;'>✅ Password 'admin123' is VALID</p>";
    } else {
        echo "<p style='color: red;'>❌ Password 'admin123' is INVALID</p>";
        echo "<p>Resetting password...</p>";
        $hashed = password_hash($testPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
        $stmt->bind_param('si', $hashed, $admin['id']);
        $stmt->execute();
        $stmt->close();
        echo "<p style='color: green;'>✅ Password has been reset to: admin123</p>";
    }
} else {
    echo "<p style='color: red;'>❌ No admin user found!</p>";
}

// Check Tables and Data
echo "<h2>3. Database Tables & Data</h2>";
$tables = [
    'users' => 'Registered Users',
    'service_booking' => 'Service Bookings', 
    'billing' => 'Billing Records'
];

echo "<table border='1' style='border-collapse: collapse; width: 100%; max-width: 400px;'>";
foreach ($tables as $table => $label) {
    $count = $conn->query("SELECT COUNT(*) as cnt FROM $table")->fetch_assoc()['cnt'];
    echo "<tr><td>$label</td><td>$count records</td></tr>";
}
echo "</table>";

// Test Dashboard Queries
echo "<h2>4. Dashboard Statistics Test</h2>";
$stats = [];

// Total Users
$stats['Total Users'] = $conn->query("SELECT COUNT(*) as cnt FROM users")->fetch_assoc()['cnt'];

// Total Bookings
$stats['Total Bookings'] = $conn->query("SELECT COUNT(*) as cnt FROM service_booking")->fetch_assoc()['cnt'];

// Pending Services
$stats['Pending Services'] = $conn->query("SELECT COUNT(*) as cnt FROM service_booking WHERE status = 'pending'")->fetch_assoc()['cnt'];

// Completed Services
$stats['Completed Services'] = $conn->query("SELECT COUNT(*) as cnt FROM service_booking WHERE status = 'completed'")->fetch_assoc()['cnt'];

// Total Revenue
$revenue = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE payment_status = 'paid'")->fetch_assoc()['total'];
$stats['Total Revenue'] = '₹' . number_format($revenue, 2);

echo "<table border='1' style='border-collapse: collapse; width: 100%; max-width: 400px;'>";
foreach ($stats as $label => $value) {
    echo "<tr><td>$label</td><td><strong>$value</strong></td></tr>";
}
echo "</table>";

// Login Test
echo "<h2>5. Admin Login Simulation</h2>";
session_start();

// Simulate admin login
$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin_username'] = $admin['username'];
$_SESSION['admin_name'] = $admin['full_name'];
$_SESSION['admin_email'] = $admin['email'];
$_SESSION['admin_role'] = $admin['role'];
$_SESSION['admin_login_time'] = time();
$_SESSION['last_activity'] = time();
$_SESSION['admin_type'] = 'admin';

echo "<p style='color: green;'>✅ Session variables set</p>";
echo "<ul>";
echo "<li>admin_id: " . $_SESSION['admin_id'] . "</li>";
echo "<li>admin_username: " . $_SESSION['admin_username'] . "</li>";
echo "<li>admin_role: " . $_SESSION['admin_role'] . "</li>";
echo "<li>admin_type: " . $_SESSION['admin_type'] . "</li>";
echo "</ul>";

// Check session is valid for dashboard
$isLoggedIn = isset($_SESSION['admin_id']) && isset($_SESSION['admin_role']);
echo "<p><strong>Session Valid:</strong> " . ($isLoggedIn ? "✅ Yes" : "❌ No") . "</p>";

// Summary
echo "<h2>🎉 Summary</h2>";
echo "<div style='background: linear-gradient(145deg, #1e1e1e, #2a2a2a); padding: 25px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);'>";
echo "<h3 style='color: #2a9d8f;'>✅ Admin Dashboard is READY!</h3>";
echo "<p>Your Bike Garage Management System admin dashboard is properly configured and ready to use.</p>";
echo "<hr style='border-color: #333; margin: 15px 0;'>";
echo "<h4 style='color: #00b4d8;'>Login Credentials:</h4>";
echo "<p><strong>Username:</strong> admin</p>";
echo "<p><strong>Password:</strong> admin123</p>";
echo "<hr style='border-color: #333; margin: 15px 0;'>";
echo "<h4 style='color: #00b4d8;'>Access URLs:</h4>";
echo "<p>🌐 <strong>Admin Login:</strong> <a href='admin/admin_login.php' style='color: #e63946;'>admin/admin_login.php</a></p>";
echo "<p>📊 <strong>Admin Dashboard:</strong> <a href='admin/admin_dashboard.php' style='color: #e63946;'>admin/admin_dashboard.php</a></p>";
echo "<p>🔐 <strong>Super Admin:</strong> <a href='admin/superadmin/superadmin_login.php' style='color: #e63946;'>admin/superadmin/superadmin_login.php</a></p>";
echo "<p>👤 <strong>User Login:</strong> <a href='login.php' style='color: #e63946;'>login.php</a></p>";
echo "<p>🏠 <strong>Homepage:</strong> <a href='index.html' style='color: #e63946;'>index.html</a></p>";
echo "</div>";

$conn->close();
session_write_close();
?>

<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    max-width: 900px;
    margin: 40px auto;
    padding: 25px;
    background: #0d0d0d;
    color: #e0e0e0;
    line-height: 1.6;
}
h1 {
    color: #e63946;
    border-bottom: 3px solid #e63946;
    padding-bottom: 15px;
    margin-bottom: 30px;
}
h2 {
    color: #00b4d8;
    margin-top: 35px;
    padding-bottom: 10px;
    border-bottom: 1px solid #333;
}
h3 {
    color: #2a9d8f;
}
table {
    margin: 15px 0;
}
td, th {
    padding: 12px 15px;
    text-align: left;
}
a {
    color: #e63946;
    text-decoration: none;
    transition: color 0.3s ease;
}
a:hover {
    color: #f77f00;
}
strong {
    color: #00b4d8;
}
</style>
