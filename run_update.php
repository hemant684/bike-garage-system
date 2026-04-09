<?php
/**
 * Database Update Script
 */
$host = 'localhost';
$user = 'root';
$pass = 'root';
$db_name = 'bike_garage';

echo "Starting database update...\n";

try {
    $conn = new mysqli($host, $user, $pass);
    if ($conn->connect_error) {
        throw new Exception('Connection failed');
    }
    
    $conn->select_db($db_name);
    echo "Connected to database.\n";
    
    // Add role column
    $result = $conn->query("SHOW COLUMNS FROM admin LIKE 'role'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE admin ADD COLUMN role ENUM('admin', 'superadmin') DEFAULT 'admin' AFTER password");
        echo "Added role column to admin table.\n";
    } else {
        echo "Role column already exists.\n";
    }
    
    // Add status column
    $result = $conn->query("SHOW COLUMNS FROM admin LIKE 'status'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE admin ADD COLUMN status ENUM('active', 'inactive') DEFAULT 'active' AFTER role");
        echo "Added status column to admin table.\n";
    } else {
        echo "Status column already exists.\n";
    }
    
    // Add permissions column
    $result = $conn->query("SHOW COLUMNS FROM admin LIKE 'permissions'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE admin ADD COLUMN permissions TEXT AFTER status");
        echo "Added permissions column to admin table.\n";
    } else {
        echo "Permissions column already exists.\n";
    }
    
    // Create activity_logs table
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
        echo "Created activity_logs table.\n";
    } else {
        echo "activity_logs table already exists.\n";
    }
    
    // Create system_settings table
    $result = $conn->query("SHOW TABLES LIKE 'system_settings'");
    if ($result->num_rows == 0) {
        $conn->query("CREATE TABLE system_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) UNIQUE NOT NULL,
            setting_value TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        echo "Created system_settings table.\n";
    } else {
        echo "system_settings table already exists.\n";
    }
    
    // Update admin roles
    $conn->query("UPDATE admin SET role = 'superadmin' WHERE username = 'superadmin'");
    $conn->query("UPDATE admin SET role = 'admin' WHERE username = 'admin' AND (role IS NULL OR role = '')");
    echo "Updated admin roles.\n";
    
    // Insert superadmin if not exists
    $result = $conn->query("SELECT * FROM admin WHERE username = 'superadmin'");
    if ($result->num_rows == 0) {
        $hashed = password_hash('super123', PASSWORD_DEFAULT);
        $conn->query("INSERT INTO admin (username, password, email, full_name, role, status) VALUES ('superadmin', '$hashed', 'superadmin@bikeGarage.com', 'Super Administrator', 'superadmin', 'active')");
        echo "Inserted superadmin user.\n";
    } else {
        echo "superadmin user already exists.\n";
    }
    
    // Insert admin if not exists
    $result = $conn->query("SELECT * FROM admin WHERE username = 'admin'");
    if ($result->num_rows == 0) {
        $hashed = password_hash('admin123', PASSWORD_DEFAULT);
        $conn->query("INSERT INTO admin (username, password, email, full_name, role, status) VALUES ('admin', '$hashed', 'admin@bikeGarage.com', 'System', 'active')");
        echo " Administrator', 'adminInserted admin user.\n";
    }
    
    echo "\n=== Database update completed successfully! ===\n\n";
    echo "Login Credentials:\n";
    echo "Super Admin: superadmin / super123\n";
    echo "Admin: admin / admin123\n";
    echo "User: john@example.com / user123\n";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    
    // Try with empty password
    echo "\nTrying with empty password...\n";
    try {
        $pass = '';
        $conn = new mysqli($host, $user, $pass);
        $conn->select_db($db_name);
        
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
            $conn->query("CREATE TABLE activity_logs (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, user_type VARCHAR(20) DEFAULT 'user', action VARCHAR(100) NOT NULL, description TEXT, ip_address VARCHAR(45), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
        }
        
        $result = $conn->query("SHOW TABLES LIKE 'system_settings'");
        if ($result->num_rows == 0) {
            $conn->query("CREATE TABLE system_settings (id INT AUTO_INCREMENT PRIMARY KEY, setting_key VARCHAR(100) UNIQUE NOT NULL, setting_value TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
        }
        
        $conn->query("UPDATE admin SET role = 'superadmin' WHERE username = 'superadmin'");
        $conn->query("UPDATE admin SET role = 'admin' WHERE username = 'admin' AND (role IS NULL OR role = '')");
        
        $result = $conn->query("SELECT * FROM admin WHERE username = 'superadmin'");
        if ($result->num_rows == 0) {
            $hashed = password_hash('super123', PASSWORD_DEFAULT);
            $conn->query("INSERT INTO admin (username, password, email, full_name, role, status) VALUES ('superadmin', '$hashed', 'superadmin@bikeGarage.com', 'Super Administrator', 'superadmin', 'active')");
        }
        
        echo "\nDatabase updated successfully with empty password!\n";
        $conn->close();
        
    } catch (Exception $e2) {
        echo "Error with empty password: " . $e2->getMessage() . "\n";
    }
}

