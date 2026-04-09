<?php
/**
 * Security Functions
 * Bike Garage Management System
 * Version 2.0
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if admin is logged in
 */
function isAdmin() {
    return isset($_SESSION['admin_id']) && isset($_SESSION['admin_role']);
}

/**
 * Check if superadmin is logged in
 */
function isSuperAdmin() {
    return isset($_SESSION['admin_id']) && 
           isset($_SESSION['admin_role']) && 
           $_SESSION['admin_role'] === 'superadmin';
}

/**
 * Get current user type
 */
function getCurrentUserType() {
    if (isSuperAdmin()) return 'superadmin';
    if (isAdmin()) return 'admin';
    if (isLoggedIn()) return 'user';
    return 'guest';
}

/**
 * Require login - redirect to login page if not logged in
 */
function requireLogin($redirect = 'login.php') {
    if (!isLoggedIn()) {
        header("Location: $redirect");
        exit;
    }
}

/**
 * Require admin login - redirect to admin login if not logged in
 */
function requireAdmin($redirect = 'admin_login.php') {
    if (!isAdmin()) {
        header("Location: $redirect");
        exit;
    }
    
    // Check for admin role
    if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'superadmin') {
        // Superadmin can access all admin pages
        return 'superadmin';
    }
    
    return 'admin';
}

/**
 * Require superadmin login
 */
function requireSuperAdmin($redirect = 'superadmin_login.php') {
    if (!isSuperAdmin()) {
        header("Location: $redirect");
        exit;
    }
}

/**
 * Check admin permission
 */
function hasPermission($permission) {
    if (!isAdmin()) return false;
    
    // Superadmin has all permissions
    if ($_SESSION['admin_role'] === 'superadmin') return true;
    
    // Get permissions from session
    $permissions = json_decode($_SESSION['admin_permissions'] ?? '{}', true);
    
    return isset($permissions[$permission]) && $permissions[$permission];
}

/**
 * Log activity
 */
function logActivity($action, $description = '') {
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
        return;
    }
    
    $user_id = $_SESSION['user_id'] ?? $_SESSION['admin_id'] ?? null;
    $user_type = getCurrentUserType();
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    
    // Insert into activity_logs table
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, user_type, action, description, ip_address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $user_type, $action, $description, $ip_address);
    $stmt->execute();
    $stmt->close();
}

/**
 * Generate CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 */
function validateCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    global $conn;
    
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $data = $conn->real_escape_string($data);
    
    return $data;
}

/**
 * Sanitize output
 */
function sanitizeOutput($data) {
    if (is_array($data)) {
        return array_map('sanitizeOutput', $data);
    }
    
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Hash password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Generate random string
 */
function generateRandomString($length = 10) {
    return bin2hex(random_bytes($length));
}

/**
 * Get user IP address
 */
function getUserIP() {
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}

/**
 * Check if request is AJAX
 */
function isAjaxRequest() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Send JSON response
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Set flash message
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get flash message
 */
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Display flash message
 */
function displayFlash() {
    $flash = getFlash();
    if ($flash) {
        echo '<div class="alert alert-' . sanitizeOutput($flash['type']) . '">';
        echo '<i class="fas fa-info-circle"></i> ' . sanitizeOutput($flash['message']);
        echo '</div>';
    }
}

/**
 * Check account status
 */
function checkAccountStatus($userType, $userId) {
    global $conn;
    
    if ($userType === 'user') {
        $stmt = $conn->prepare("SELECT status FROM users WHERE id = ?");
    } else {
        $stmt = $conn->prepare("SELECT status FROM admin WHERE id = ?");
    }
    
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['status'] === 'active';
    }
    
    return false;
}

/**
 * Update last login time
 */
function updateLastLogin($userType, $userId) {
    global $conn;
    
    if ($userType === 'admin') {
        $stmt = $conn->prepare("UPDATE admin SET last_login = NOW() WHERE id = ?");
    } else {
        return; // Users don't have last_login tracking in this system
    }
    
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

/**
 * Format date for display
 */
function formatDate($date, $format = 'd M Y') {
    return date($format, strtotime($date));
}

/**
 * Format currency
 */
function formatCurrency($amount, $currency = '₹') {
    return $currency . number_format($amount, 2);
}

/**
 * Get status badge class
 */
function getStatusBadgeClass($status) {
    $classes = [
        'pending' => 'warning',
        'confirmed' => 'info',
        'in_progress' => 'primary',
        'waiting_parts' => 'secondary',
        'completed' => 'success',
        'cancelled' => 'danger',
        'delivered' => 'success',
        'paid' => 'success',
        'partial' => 'warning',
        'refunded' => 'danger',
        'active' => 'success',
        'inactive' => 'secondary',
        'blocked' => 'danger'
    ];
    
    return $classes[$status] ?? 'secondary';
}

/**
 * Generate booking number
 */
function generateBookingNumber() {
    global $conn;
    
    $year = date('Y');
    $result = $conn->query("SELECT MAX(CAST(SUBSTRING(booking_number, 8) AS UNSIGNED)) as max_num FROM service_booking WHERE booking_number LIKE 'BG-$year-%'");
    $row = $result->fetch_assoc();
    $nextNum = ($row['max_num'] ?? 0) + 1;
    
    return "BG-$year-" . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
}

/**
 * Generate bill number
 */
function generateBillNumber() {
    global $conn;
    
    $result = $conn->query("SELECT MAX(CAST(SUBSTRING(bill_number, 5) AS UNSIGNED)) as max_num FROM billing");
    $row = $result->fetch_assoc();
    $nextNum = ($row['max_num'] ?? 0) + 1;
    
    return "INV-" . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
}

/**
 * Calculate tax amount
 */
function calculateTax($amount, $taxRate = 8.25) {
    return round($amount * ($taxRate / 100), 2);
}

/**
 * Upload image file
 */
function uploadImage($file, $uploadDir = '../images/uploads/', $allowedTypes = ['jpg', 'jpeg', 'png', 'gif']) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Upload error: ' . $file['error']];
    }
    
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($extension, $allowedTypes)) {
        return ['success' => false, 'error' => 'Invalid file type. Allowed: ' . implode(', ', $allowedTypes)];
    }
    
    $maxSize = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'error' => 'File too large. Maximum size: 5MB'];
    }
    
    $newFilename = generateRandomString(16) . '.' . $extension;
    $uploadPath = $uploadDir . $newFilename;
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return ['success' => true, 'filename' => $newFilename];
    }
    
    return ['success' => false, 'error' => 'Failed to upload file'];
}

/**
 * Delete file
 */
function deleteFile($filePath) {
    if (file_exists($filePath)) {
        return unlink($filePath);
    }
    return false;
}

/**
 * Get system setting
 */
function getSetting($key, $default = '') {
    global $conn;
    
    $stmt = $conn->prepare("SELECT setting_value FROM system_settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['setting_value'];
    }
    
    return $default;
}

/**
 * Update system setting
 */
function updateSetting($key, $value) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO system_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    $stmt->bind_param("ss", $key, $value);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}

/**
 * Redirect with message
 */
function redirectWith($url, $type, $message) {
    setFlash($type, $message);
    header("Location: $url");
    exit;
}

/**
 * Get time ago
 */
function timeAgo($datetime) {
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    
    return formatDate($datetime);
}

/**
 * Export data to CSV
 */
function exportToCSV($data, $filename) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit;
}

/**
 * Get all months for reporting
 */
function getMonths() {
    return [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];
}

