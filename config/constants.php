<?php
// medico/config/constants.php

// Make sure we're not including this file multiple times
if (!defined('APP_NAME')) {

    // Simple BASE_URL definition
    define('BASE_URL', 'http://localhost/medico/public/');
    
    // Application Constants
    define('APP_NAME', 'Medico - Patient Management System');
    define('APP_VERSION', '1.0.0');
    
    // User Roles (MUST match your database)
    define('ROLE_SUPER_ADMIN', 1);
    define('ROLE_DOCTOR', 2);
    define('ROLE_RECEPTIONIST', 3);
    define('ROLE_PHARMACIST', 4);
    
    // Session Configuration
    define('SESSION_TIMEOUT', 3600);
    
    // Directory Paths
    define('ROOT_PATH', dirname(dirname(__FILE__)) . '/');
    define('VIEW_PATH', ROOT_PATH . 'views/');
    define('UPLOAD_PATH', ROOT_PATH . 'assets/uploads/');
    
    // Debug: Uncomment to check
    // echo "Constants loaded! BASE_URL: " . BASE_URL . "<br>";
}
?>