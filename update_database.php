<?php
/**
 * Database Update Script
 * Run this to update the existing database with new schema changes
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🚴 Bike Garage Management System - Database Update</h1>";

$host = 'localhost';
$user = 'root';
$pass = 'root'; // MAMP default
$db_name = 'bike_garage';

try {
    // Connect to MySQL
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "<p style='color: green;'>✓ Connected to MySQL</p>";
    
    $conn->select_db($db_name);
    echo "<p style='color: green;'>✓ Selected database: $db_name</p>";
    
    // Check and add role column to admin table
    $result = $conn->query("SHOW COLUMNS FROM admin LIKE 'role'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE admin ADD COLUMN role ENUM('admin', 'superadmin') DEFAULT 'admin' AFTER password");
        echo "<p style='color: green;'>✓ Added 'role' column to admin table</p>";
        
        // Set default role for existing admin
        $conn->query("UPDATE admin SET role = 'admin' WHERE role IS NULL OR role = ''");
        echo "<p style='color: green;'>✓ Set default role for existing admins</p>";
    } else {
        echo "<p style='color: orange;'>✓ 'role' column already exists</p>";
    }
    
    // Check and add status column to admin table
    $result = $conn->query("SHOW COLUMNS FROM admin LIKE 'status'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE admin ADD COLUMN status ENUM('active', 'inactive') DEFAULT 'active' AFTER role");
        echo "<p style='color: green;'>✓ Added 'status' column to admin table</p>";
    } else {
        echo "<p style='color: orange;'>✓ 'status' column already exists</p>";
    }
    
    // Check and add permissions column to admin table
    $result = $conn->query("SHOW COLUMNS FROM admin LIKE 'permissions'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE admin ADD COLUMN permissions TEXT AFTER status");
        echo "<p style='color: green;'>✓ Added 'permissions' column to admin table</p>";
    } else {
        echo "<p style='color: orange;'>✓ 'permissions' column already exists</p>";
    }
    
    // Create activity_logs table if not exists
    $result = $conn->query("SHOW TABLES LIKE 'activity_logs'");
    if ($result->num_rows == 0) {
        $sql = "CREATE TABLE activity_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            user_type VARCHAR(20) DEFAULT 'user',
            action VARCHAR(100) NOT NULL,
            description TEXT,
            ip_address VARCHAR(45),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->query($sql);
        echo "<p style='color: green;'>✓ Created 'activity_logs' table</p>";
    } else {
        echo "<p style='color: orange;'>✓ 'activity_logs' table already exists</p>";
    }
    
    // Create system_settings table if not exists
    $result = $conn->query("SHOW TABLES LIKE 'system_settings'");
    if ($result->num_rows == 0) {
        $sql = "CREATE TABLE system_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) UNIQUE NOT NULL,
            setting_value TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $conn->query($sql);
        echo "<p style='color: green;'>✓ Created 'system_settings' table</p>";
    } else {
        echo "<p style='color: orange;'>✓ 'system_settings' table already exists</p>";
    }
    
    // Update admin role if not set
    $conn->query("UPDATE admin SET role = 'superadmin' WHERE username = 'superadmin'");
    $conn->query("UPDATE admin SET role = 'admin' WHERE username = 'admin' AND role IS NULL");
    
    // Insert superadmin if not exists
    $result = $conn->query("SELECT * FROM admin WHERE username = 'superadmin'");
    if ($result->num_rows == 0) {
        $hashed = password_hash('super123', PASSWORD_DEFAULT);
        $conn->query("INSERT INTO admin (username, password, email, full_name, role, status) VALUES ('superadmin', '$hashed', 'superadmin@bikeGarage.com', 'Super Administrator', 'superadmin', 'active')");
        echo "<p style='color: green;'>✓ Inserted superadmin user</p>";
    }
    
    // Update admin password if needed (admin123)
    $result = $conn->query("SELECT * FROM admin WHERE username = 'admin'");
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if ($admin['password'] == '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi') {
            $hashed = password_hash('admin123', PASSWORD_DEFAULT);
            $conn->query("UPDATE admin SET password = '$hashed' WHERE username = 'admin'");
            echo "<p style='color: green;'>✓ Updated admin password hash</p>";
        }
    }
    
    echo "<h2 style='color: green;'>✅ Database Update Complete!</h2>";
    echo "<div style='background: #1e1e1e; padding: 20px; border-radius: 10px; margin-top: 20px;'>";
    echo "<h3>Login Credentials:</h3>";
    echo "<p><strong>Super Admin:</strong> superadmin / super123</p>";
    echo "<p><strong>Admin:</strong> admin / admin123</p>";
    echo "<p><strong>User:</strong> john@example.com / user123</p>";
    echo "</div>";
    
    echo "<div style='margin-top: 20px;'>";
    echo "<a href='index.html' style='background: #2a9d8f; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🌐 Open Homepage</a>";
    echo "<a href='superadmin/superadmin_login.php' style='background: #e63946; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;'>🛠️ Super Admin Login</a>";
    echo "</div>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    
    // Try with empty password (XAMPP)
    echo "<p style='color: orange;'>Trying with empty password...</p>";
    
    try {
        $pass = '';
        $conn = new mysqli($host, $user, $pass);
        $conn->select_db($db_name);
        
        // Run updates...
        $result = $conn->query("SHOW COLUMNS FROM admin LIKE 'role'");
        if ($result->num_rows == 0) {
            $conn->query("ALTER TABLE admin ADD COLUMN role ENUM('admin', 'superadmin') DEFAULT 'admin' AFTER password");
        }
        
        $result = $conn->query("SHOW COLUMNS FROM admin LIKE 'status'");
        if ($result->num_rows == 0) {
            $conn->query("ALTER TABLE admin ADD COLUMN status ENUM('active', 'inactive') DEFAULT 'active' AFTER role");
        }
        
        $result = $conn->query("SHOW TABLES LIKE 'activity_logs'");
        if ($result->num_rows == 0) {
            $conn->query("CREATE TABLE activity_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                user_type VARCHAR(20) DEFAULT 'user',
                action VARCHAR(100) NOT NULL,
                description TEXT,
                ip_address VARCHAR(45),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
        }
        
        $conn->query("UPDATE admin SET role = 'superadmin' WHERE username = 'superadmin'");
        $conn->query("UPDATE admin SET role = 'admin' WHERE username = 'admin' AND role IS NULL");
        
        echo "<p style='color: green;'>✓ Database updated successfully!</p>";
        
        $conn->close();
        
    } catch (Exception $e2) {
        echo "<p style='color: red;'>❌ Error: " . $e2->getMessage() . "</p>";
    }
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background: #0d0d0d;
    color: #fff;
}
h1 { color: #e63946; }
a {
    display: inline-block;
    margin-top: 10px;
}
</style>

