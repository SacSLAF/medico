<?php
// medico/public/index.php

// Enable all errors (comment out in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the project root path
$root_path = dirname(__DIR__);

// Load configuration
require_once $root_path . '/config/constants.php';

// Get URL
$url = $_GET['url'] ?? 'auth/login';

// Remove trailing slash
$url = rtrim($url, '/');

// Split URL into parts
$url_parts = explode('/', $url);
$controller_name = $url_parts[0] ?? 'auth';
$method_name = $url_parts[1] ?? 'login';

// Map URLs to controllers
$routes = [
    'auth' => 'AuthController',
    'dashboard' => 'DashboardController',
    'users' => 'UserController',
    'reports' => 'ReportsController',
    'system-settings' => 'SystemSettingsController',
    // Add more controllers here as we create them
];

// Get the controller class name
$controller_class = $routes[$controller_name] ?? null;

if ($controller_class) {
    $controller_file = $root_path . '/controllers/' . $controller_class . '.php';
    
    if (file_exists($controller_file)) {
        require_once $controller_file;
        
        // Create controller instance
        $controller = new $controller_class();
        
        // Check if method exists
        if (method_exists($controller, $method_name)) {
            // Call the method with any additional parameters
            $params = array_slice($url_parts, 2);
            call_user_func_array([$controller, $method_name], $params);
        } else {
            // Method not found, try index method
            if (method_exists($controller, 'index')) {
                $controller->index();
            } else {
                http_response_code(404);
                echo "404 - Method '$method_name' not found in $controller_class";
            }
        }
    } else {
        http_response_code(404);
        echo "404 - Controller file not found: $controller_file";
    }
} else {
    http_response_code(404);
    echo "404 - Page not found: $url";
}