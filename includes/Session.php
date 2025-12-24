<?php
class Session {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public function get($key) {
        return $_SESSION[$key] ?? null;
    }
    
    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    public function destroy() {
        session_destroy();
        $_SESSION = array();
    }
    
    public function setFlash($type, $message) {
        $_SESSION['flash'][$type] = $message;
    }
    
    public function getFlash($type) {
        if (isset($_SESSION['flash'][$type])) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        return null;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']) && isset($_SESSION['role']);
    }
    
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }
    }
    
    public function hasRole($requiredRole) {
        return isset($_SESSION['role']) && $_SESSION['role'] == $requiredRole;
    }
    
    public function requireRole($requiredRole) {
        if (!$this->hasRole($requiredRole)) {
            $this->setFlash('error', 'Access denied. Insufficient permissions.');
            header('Location: ' . BASE_URL . 'dashboard');
            exit();
        }
    }
}