<?php
/**
 * Session Management
 * Bike Garage Management System
 * Version 2.0
 */

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Set session timeout (in seconds)
 */
define('SESSION_TIMEOUT', 3600); // 1 hour

/**
 * Check if session is expired
 */
function isSessionExpired() {
    if (!isset($_SESSION['last_activity'])) {
        return true;
    }
    
    $elapsed = time() - $_SESSION['last_activity'];
    return $elapsed > SESSION_TIMEOUT;
}

/**
 * Update last activity timestamp
 */
function updateLastActivity() {
    $_SESSION['last_activity'] = time();
}

/**
 * Initialize session for user login
 */
function initUserSession($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_login_time'] = time();
    $_SESSION['last_activity'] = time();
    $_SESSION['user_type'] = 'user';
}

/**
 * Initialize session for admin login
 */
function initAdminSession($admin) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_username'] = $admin['username'];
    $_SESSION['admin_name'] = $admin['full_name'];
    $_SESSION['admin_email'] = $admin['email'];
    $_SESSION['admin_role'] = $admin['role'];
    $_SESSION['admin_permissions'] = $admin['permissions'] ?? '{}';
    $_SESSION['admin_login_time'] = time();
    $_SESSION['last_activity'] = time();
    $_SESSION['admin_type'] = 'admin';
}

/**
 * Validate current session
 */
function validateSession() {
    // Skip validation for login pages
    $currentPage = basename($_SERVER['PHP_SELF']);
    $loginPages = ['login.php', 'admin_login.php', 'superadmin_login.php', 'register.php', 'forgot_password.php'];
    
    if (in_array($currentPage, $loginPages)) {
        return true;
    }
    
    // Check if logged in
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
        return false;
    }
    
    // Check session expiry
    if (isSessionExpired()) {
        destroySession();
        return false;
    }
    
    // Update last activity
    updateLastActivity();
    
    return true;
}

/**
 * Destroy session
 */
function destroySession() {
    $_SESSION = [];
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}

/**
 * Regenerate session ID
 */
function regenerateSession() {
    session_regenerate_id(true);
}

/**
 * Check if user has access to specific page
 */
function hasPageAccess($pageType = 'user') {
    $currentPage = basename($_SERVER['PHP_SELF']);
    
    if ($pageType === 'admin' && !isset($_SESSION['admin_id'])) {
        return false;
    }
    
    if ($pageType === 'superadmin' && (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] !== 'superadmin')) {
        return false;
    }
    
    if ($pageType === 'user' && !isset($_SESSION['user_id'])) {
        return false;
    }
    
    return true;
}

/**
 * Get redirect URL based on user type
 */
function getDashboardUrl() {
    if (isset($_SESSION['admin_id'])) {
        if ($_SESSION['admin_role'] === 'superadmin') {
            return 'superadmin/superadmin_dashboard.php';
        }
        return 'admin/admin_dashboard.php';
    }
    
    if (isset($_SESSION['user_id'])) {
        return 'user/user_dashboard.php';
    }
    
    return 'login.php';
}

/**
 * Check if user can access admin panel
 */
function canAccessAdmin() {
    return isset($_SESSION['admin_id']) && 
           in_array($_SESSION['admin_role'], ['admin', 'superadmin']);
}

/**
 * Check if user is superadmin
 */
function isUserSuperAdmin() {
    return isset($_SESSION['admin_id']) && 
           $_SESSION['admin_role'] === 'superadmin';
}

/**
 * Set remember me token
 */
function setRememberToken($userId, $token) {
    $_SESSION['remember_token'] = $token;
    $_SESSION['remember_user'] = $userId;
}

/**
 * Clear remember token
 */
function clearRememberToken() {
    unset($_SESSION['remember_token']);
    unset($_SESSION['remember_user']);
}

/**
 * Get current page URL
 */
function getCurrentUrl() {
    $url = $_SERVER['REQUEST_URI'];
    $url = strtok($url, '?');
    return $url;
}

/**
 * Store previous URL for redirect
 */
function storePreviousUrl() {
    $_SESSION['previous_url'] = getCurrentUrl();
}

/**
 * Get previous URL
 */
function getPreviousUrl($default = 'index.html') {
    return $_SESSION['previous_url'] ?? $default;
}

/**
 * Add message to session
 */
function addMessage($type, $message) {
    if (!isset($_SESSION['messages'])) {
        $_SESSION['messages'] = [];
    }
    
    $_SESSION['messages'][] = [
        'type' => $type,
        'message' => $message,
        'time' => time()
    ];
}

/**
 * Get and clear messages
 */
function getMessages() {
    $messages = $_SESSION['messages'] ?? [];
    unset($_SESSION['messages']);
    return $messages;
}

/**
 * Display messages
 */
function displayMessages() {
    $messages = getMessages();
    
    foreach ($messages as $msg) {
        echo '<div class="alert alert-' . escape($msg['type']) . '">';
        echo '<i class="fas fa-info-circle"></i> ' . escape($msg['message']);
        echo '</div>';
    }
}

