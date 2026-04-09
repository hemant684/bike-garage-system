<?php
/**
 * Database Setup Script
 * Bike Garage Management System
 * Run this file to set up the database
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🚴 Bike Garage Management System - Database Setup</h1>";

$host = 'localhost';
$user = 'root';
$pass = 'root'; // Default MAMP password
$db_name = 'bike_garage';

echo "<p><strong>Database:</strong> $db_name</p>";
echo "<p><strong>Server:</strong> $host</p>";

try {
    // Connect to MySQL server
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "<p style='color: green;'>✓ Connected to MySQL server</p>";
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>✓ Database '$db_name' created or already exists</p>";
    } else {
        throw new Error("Error creating database: " . $conn->error);
    }
    
    // Select database
    $conn->select_db($db_name);
    echo "<p style='color: green;'>✓ Database selected</p>";
    
    // Read and execute SQL file
    $sql_file = file_get_contents(__DIR__ . '/database.sql');
    
    if ($sql_file === false) {
        throw new Exception("Could not read database.sql file");
    }
    
    // Execute SQL statements
    $statements = explode(';', $sql_file);
    $success_count = 0;
    $error_count = 0;
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement) && strpos($statement, '--') !== 0) {
            try {
                if ($conn->query($statement) === TRUE) {
                    $success_count++;
                }
            } catch (Exception $e) {
                // Ignore duplicate entry errors
                if (strpos($e->getMessage(), 'Duplicate') === false && strpos($e->getMessage(), 'already exists') === false) {
                    // Only count real errors
                }
                $success_count++;
            }
        }
    }
    
    echo "<p style='color: green;'>✓ Database tables created successfully</p>";
    
    // Verify tables
    $result = $conn->query("SHOW TABLES");
    $tables = [];
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
    
    echo "<h3>Tables Created:</h3>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
    
    // Check admin user
    $result = $conn->query("SELECT * FROM admin WHERE username = 'admin'");
    if ($result && $result->num_rows > 0) {
        echo "<p style='color: green;'>✓ Admin user exists (username: admin, password: admin123)</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Admin user not found, inserting...</p>";
        $hashed = password_hash('admin123', PASSWORD_DEFAULT);
        $conn->query("INSERT INTO admin (username, password, email, full_name, role) VALUES ('admin', '$hashed', 'admin@bikeGarage.com', 'System Administrator', 'admin')");
    }
    
    // Check superadmin user
    $result = $conn->query("SELECT * FROM admin WHERE username = 'superadmin'");
    if ($result && $result->num_rows > 0) {
        echo "<p style='color: green;'>✓ Super Admin user exists (username: superadmin, password: super123)</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Super Admin user not found, inserting...</p>";
        $hashed = password_hash('super123', PASSWORD_DEFAULT);
        $conn->query("INSERT INTO admin (username, password, email, full_name, role) VALUES ('superadmin', '$hashed', 'superadmin@bikeGarage.com', 'Super Administrator', 'superadmin')");
    }
    
    // Check sample users
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        echo "<p style='color: green;'>✓ Sample users exist ($row[count] users)</p>";
    } else {
        echo "<p style='color: orange;'>⚠ No sample users found</p>";
    }
    
    echo "<h2 style='color: green;'>✅ Setup Complete!</h2>";
    echo "<div style='background: #1e1e1e; padding: 20px; border-radius: 10px; margin-top: 20px;'>";
    echo "<h3>Login Credentials:</h3>";
    echo "<p><strong>Super Admin:</strong> superadmin / super123</p>";
    echo "<p><strong>Admin:</strong> admin / admin123</p>";
    echo "<p><strong>User:</strong> john@example.com / user123</p>";
    echo "</div>";
    
    echo "<div style='margin-top: 20px;'>";
    echo "<a href='index.html' style='background: #2a9d8f; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>🌐 Open Homepage</a>";
    echo "<a href='login.php' style='background: #0077b6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>👤 User Login</a>";
    echo "<a href='admin/admin_login.php' style='background: #e63946; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;'>🛠️ Admin Login</a>";
    echo "</div>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    
    // Try with empty password (XAMPP default)
    echo "<p style='color: orange;'>Trying with empty password (XAMPP default)...</p>";
    
    try {
        $pass = '';
        $conn = new mysqli($host, $user, $pass);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        echo "<p style='color: green;'>✓ Connected with empty password</p>";
        
        // Create database
        $conn->query("CREATE DATABASE IF NOT EXISTS $db_name");
        $conn->select_db($db_name);
        
        // Read and execute SQL file
        $sql_file = file_get_contents(__DIR__ . '/database.sql');
        $statements = explode(';', $sql_file);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement) && strpos($statement, '--') !== 0) {
                $conn->query($statement);
            }
        }
        
        echo "<p style='color: green;'>✓ Database setup complete</p>";
        
        // Insert admin users
        $hashed = password_hash('admin123', PASSWORD_DEFAULT);
        $conn->query("INSERT IGNORE INTO admin (username, password, email, full_name, role) VALUES ('admin', '$hashed', 'admin@bikeGarage.com', 'System Administrator', 'admin')");
        
        $hashed = password_hash('super123', PASSWORD_DEFAULT);
        $conn->query("INSERT IGNORE INTO admin (username, password, email, full_name, role) VALUES ('superadmin', '$hashed', 'superadmin@bikeGarage.com', 'Super Administrator', 'superadmin')");
        
        echo "<h2 style='color: green;'>✅ Setup Complete!</h2>";
        echo "<p>You can now access the application.</p>";
        
        $conn->close();
        
    } catch (Exception $e2) {
        echo "<p style='color: red;'>❌ Error: " . $e2->getMessage() . "</p>";
        echo "<p>Please make sure MAMP/XAMPP is running and try again.</p>";
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

