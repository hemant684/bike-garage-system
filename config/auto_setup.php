<?php
/**
 * Auto Database Setup
 * Automatically creates database and tables if they don't exist
 * Include this file at the top of any page that needs database access
 */

error_reporting(E_ALL);
ini_set('display_errors', 0);

$auto_setup_done = false;

/**
 * Check and setup database automatically
 */
function auto_setup_database() {
    global $auto_setup_done;
    
    if ($auto_setup_done) {
        return true;
    }
    
    $socket = '/Applications/MAMP/tmp/mysql/mysql.sock';
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db_name = 'bike_garage';
    
    // Try different connection methods
    $connection_attempts = [
        // Try with socket and empty password (MAMP default)
        ['host' => $host, 'user' => $user, 'pass' => '', 'socket' => $socket],
        // Try with socket and 'root' password (older MAMP)
        ['host' => $host, 'user' => $user, 'pass' => 'root', 'socket' => $socket],
        // Try without socket and empty password
        ['host' => $host, 'user' => $user, 'pass' => '', 'socket' => null],
        // Try without socket and 'root' password
        ['host' => $host, 'user' => $user, 'pass' => 'root', 'socket' => null],
    ];
    
    $conn = null;
    
    foreach ($connection_attempts as $attempt) {
        try {
            if ($attempt['socket']) {
                $conn = new mysqli($attempt['host'], $attempt['user'], $attempt['pass'], '', 3306, $attempt['socket']);
            } else {
                $conn = new mysqli($attempt['host'], $attempt['user'], $attempt['pass'], '', 3306);
            }
            
            if ($conn->connect_error === null) {
                break;
            }
        } catch (\Exception $e) {
            continue;
        }
    }
    
    if (!$conn || $conn->connect_error) {
        return false;
    }
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    if ($conn->query($sql) === TRUE) {
        // Select the database
        $conn->select_db($db_name);
        
        // Check if tables exist
        $result = $conn->query("SHOW TABLES");
        if ($result && $result->num_rows == 0) {
            // Import database.sql
            $sql_file = file_get_contents(__DIR__ . '/../database.sql');
            if ($sql_file) {
                $statements = explode(';', $sql_file);
                foreach ($statements as $statement) {
                    $statement = trim($statement);
                    if (!empty($statement) && strpos($statement, '--') !== 0) {
                        $conn->query($statement);
                    }
                }
            }
            
            // Insert default admin users
            $hashed_admin = password_hash('admin123', PASSWORD_DEFAULT);
            $hashed_superadmin = password_hash('super123', PASSWORD_DEFAULT);
            
            $conn->query("INSERT IGNORE INTO admin (username, password, email, full_name, role) VALUES ('admin', '$hashed_admin', 'admin@bikeGarage.com', 'System Administrator', 'admin')");
            $conn->query("INSERT IGNORE INTO admin (username, password, email, full_name, role) VALUES ('superadmin', '$hashed_superadmin', 'superadmin@bikeGarage.com', 'Super Administrator', 'superadmin')");
        }
    }
    
    $conn->close();
    $auto_setup_done = true;
    return true;
}

// Run auto setup - suppress errors on page load
auto_setup_database();

