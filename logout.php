<?php
/**
 * Logout Handler
 * Bike Garage Management System
 */

session_start();
require_once 'config/functions.php';

// Log the logout activity
if (isset($_SESSION['user_type'])) {
    logActivity('logout', ucfirst($_SESSION['user_type']) . ' logged out');
}

// Destroy session
destroySession();

// Redirect to login page
redirect('login.php');

