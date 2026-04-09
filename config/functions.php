<?php
/**
 * Common Functions
 * Bike Garage Management System
 * Version 2.0
 */

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Get database connection
 */
function getDbConnection() {
    static $conn = null;
    
    if ($conn === null) {
        require_once __DIR__ . '/db_config.php';
        $conn = DatabaseConnection::getInstance()->getConnection();
    }
    
    return $conn;
}

/**
 * Sanitize input data
 */
function sanitize($data) {
    $conn = getDbConnection();
    
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $data = $conn->real_escape_string($data);
    
    return $data;
}

/**
 * Sanitize output (HTML)
 */
function escape($data) {
    if (is_array($data)) {
        return array_map('escape', $data);
    }
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
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
 * Redirect to URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Redirect with flash message
 */
function redirectWith($url, $type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
    redirect($url);
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
 * Get and clear flash message
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
        echo '<div class="alert alert-' . escape($flash['type']) . '">
            <i class="fas fa-info-circle"></i> ' . escape($flash['message']) . '
        </div>';
    }
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
    return isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token'];
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
 * Format date
 */
function formatDate($date, $format = 'd M Y') {
    return date($format, strtotime($date));
}

/**
 * Format datetime
 */
function formatDateTime($date, $format = 'd M Y, h:i A') {
    return date($format, strtotime($date));
}

/**
 * Format currency
 */
function formatCurrency($amount, $currency = '₹') {
    return $currency . number_format((float)$amount, 2);
}

/**
 * Get status badge class
 */
function getStatusClass($status) {
    $classes = [
        'pending' => 'warning',
        'confirmed' => 'info',
        'approved' => 'info',
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
    
    $status = strtolower(str_replace(' ', '_', $status));
    return $classes[$status] ?? 'secondary';
}

/**
 * Get status label
 */
function getStatusLabel($status) {
    return ucwords(str_replace('_', ' ', $status));
}

/**
 * Generate booking number
 */
function generateBookingNumber() {
    $conn = getDbConnection();
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
    $conn = getDbConnection();
    $result = $conn->query("SELECT MAX(CAST(SUBSTRING(bill_number, 5) AS UNSIGNED)) as max_num FROM billing");
    $row = $result->fetch_assoc();
    $nextNum = ($row['max_num'] ?? 0) + 1;
    return "INV-" . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
}

/**
 * Calculate tax
 */
function calculateTax($amount, $taxRate = 8.25) {
    return round($amount * ($taxRate / 100), 2);
}

/**
 * Get system setting
 */
function getSetting($key, $default = '') {
    $conn = getDbConnection();
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
    $conn = getDbConnection();
    $stmt = $conn->prepare("INSERT INTO system_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    $stmt->bind_param("ss", $key, $value);
    $stmt->execute();
    return $stmt->affected_rows > 0;
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
 * Export data to CSV
 */
function exportToCSV($data, $headers, $filename) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // Write headers
    fputcsv($output, $headers);
    
    // Write data
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit;
}

/**
 * Log activity
 */
function logActivity($action, $description = '') {
    $conn = getDbConnection();
    
    $user_id = $_SESSION['user_id'] ?? $_SESSION['admin_id'] ?? null;
    $user_type = getCurrentUserType();
    $ip_address = getUserIP();
    
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, user_type, action, description, ip_address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $user_type, $action, $description, $ip_address);
    $stmt->execute();
    $stmt->close();
}

/**
 * Get time ago string
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
 * Validate email format
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate phone number (Indian format)
 */
function isValidPhone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return strlen($phone) >= 10 && strlen($phone) <= 15;
}

/**
 * Upload image file
 */
function uploadImage($file, $uploadDir = '../images/uploads/', $maxSize = 5242880, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp']) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Upload error: ' . $file['error']];
    }
    
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($extension, $allowedTypes)) {
        return ['success' => false, 'error' => 'Invalid file type. Allowed: ' . implode(', ', $allowedTypes)];
    }
    
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'error' => 'File too large. Maximum size: ' . round($maxSize / 1048576, 1) . 'MB'];
    }
    
    $newFilename = generateRandomString(16) . '.' . $extension;
    $uploadPath = $uploadDir . $newFilename;
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return ['success' => true, 'filename' => $newFilename, 'path' => $uploadPath];
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
 * Get month name
 */
function getMonthName($month) {
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];
    return $months[$month] ?? '';
}

/**
 * Get all months
 */
function getMonths() {
    return [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];
}

/**
 * Require login
 */
function requireLogin($redirect = 'login.php') {
    if (!isLoggedIn()) {
        redirect($redirect);
    }
}

/**
 * Require admin login
 */
function requireAdmin($redirect = 'admin_login.php') {
    if (!isAdmin()) {
        redirect($redirect);
    }
}

/**
 * Require superadmin login
 */
function requireSuperAdmin($redirect = 'superadmin_login.php') {
    if (!isSuperAdmin()) {
        redirect($redirect);
    }
}

/**
 * Check admin permission
 */
function hasPermission($permission) {
    if (!isAdmin()) return false;
    if (isSuperAdmin()) return true;
    
    $permissions = json_decode($_SESSION['admin_permissions'] ?? '{}', true);
    return isset($permissions[$permission]) && $permissions[$permission];
}

/**
 * Paginate array
 */
function paginate($array, $page = 1, $perPage = 10) {
    $total = count($array);
    $totalPages = ceil($total / $perPage);
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $perPage;
    
    return [
        'data' => array_slice($array, $offset, $perPage),
        'total' => $total,
        'page' => $page,
        'perPage' => $perPage,
        'totalPages' => $totalPages
    ];
}

/**
 * Build pagination HTML
 */
function buildPagination($currentPage, $totalPages, $url) {
    $html = '<ul class="pagination">';
    
    // Previous button
    if ($currentPage > 1) {
        $html .= '<li><a href="' . $url . '?page=' . ($currentPage - 1) . '">&laquo;</a></li>';
    }
    
    // Page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            $html .= '<li class="active"><span>' . $i . '</span></li>';
        } else {
            $html .= '<li><a href="' . $url . '?page=' . $i . '">' . $i . '</a></li>';
        }
    }
    
    // Next button
    if ($currentPage < $totalPages) {
        $html .= '<li><a href="' . $url . '?page=' . ($currentPage + 1) . '">&raquo;</a></li>';
    }
    
    $html .= '</ul>';
    return $html;
}

