<?php
/**
 * Database Configuration
 * Bike Garage Management System
 * Version 2.0
 */

// Database connection settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'bike_garage');
define('DB_USER', 'root');
define('DB_PASS', '');  // Default MAMP password is empty for newer versions
define('DB_CHARSET', 'utf8mb4');

// Create database connection
class DatabaseConnection {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        // MAMP MySQL socket path for macOS
        $socket = '/Applications/MAMP/tmp/mysql/mysql.sock';
        
        // Try different connection methods
        $connection_attempts = [
            // Try with socket and empty password (MAMP default for newer versions)
            ['host' => DB_HOST, 'user' => DB_USER, 'pass' => '', 'database' => DB_NAME, 'port' => 8889, 'socket' => $socket],
            // Try with socket and 'root' password (MAMP default for older versions)
            ['host' => DB_HOST, 'user' => DB_USER, 'pass' => 'root', 'database' => DB_NAME, 'port' => 8889, 'socket' => $socket],
            // Try without socket
            ['host' => DB_HOST, 'user' => DB_USER, 'pass' => '', 'database' => DB_NAME, 'port' => 8889, 'socket' => null],
            // Try without socket and with 'root' password
            ['host' => DB_HOST, 'user' => DB_USER, 'pass' => 'root', 'database' => DB_NAME, 'port' => 8889, 'socket' => null],
        ];
        
        $this->conn = null;
        
        foreach ($connection_attempts as $attempt) {
            try {
                if ($attempt['socket']) {
                    $this->conn = new mysqli(
                        $attempt['host'], 
                        $attempt['user'], 
                        $attempt['pass'], 
                        $attempt['database'], 
                        $attempt['port'], 
                        $attempt['socket']
                    );
                } else {
                    $this->conn = new mysqli(
                        $attempt['host'], 
                        $attempt['user'], 
                        $attempt['pass'], 
                        $attempt['database'], 
                        $attempt['port']
                    );
                }
                
                if ($this->conn->connect_error === null) {
                    break; // Successfully connected
                }
            } catch (\Exception $e) {
                continue; // Try next attempt
            }
        }
        
        if ($this->conn === null || $this->conn->connect_error) {
            die("Connection failed: " . ($this->conn ? $this->conn->connect_error : "Could not establish database connection"));
        }
        
        // Set charset to utf8mb4
        $this->conn->set_charset(DB_CHARSET);
        
        // Set timezone
        $this->conn->query("SET time_zone = '+05:30'");
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    public function query($sql) {
        return $this->conn->query($sql);
    }
    
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }
    
    public function escape($string) {
        return $this->conn->real_escape_string($string);
    }
    
    public function insertId() {
        return $this->conn->insert_id;
    }
    
    public function affectedRows() {
        return $this->conn->affected_rows;
    }
    
    public function close() {
        $this->conn->close();
    }
}

// Global connection instance
$conn = DatabaseConnection::getInstance()->getConnection();

// Helper function for prepared statements
function db_prepare($sql) {
    global $conn;
    return $conn->prepare($sql);
}

// Helper function to get last insert ID
function db_insert_id() {
    global $conn;
    return $conn->insert_id;
}

// Helper function to get affected rows
function db_affected_rows() {
    global $conn;
    return $conn->affected_rows;
}

// Helper function to close connection
function db_close() {
    global $conn;
    $conn->close();
}

