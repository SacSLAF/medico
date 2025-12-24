<?php
// medico/includes/Auth.php

require_once 'Session.php';
require_once '../config/Database.php';
require_once '../classes/User.php';

class Auth {
    private $db;
    private $session;
    private $user;
    
    public function __construct() {
        $this->db = (new Database())->connect();
        $this->session = new Session();
        $this->user = new User($this->db);
    }
    
    public function login($username, $password) {
        // Validate input
        if (empty($username) || empty($password)) {
            return ['success' => false, 'message' => 'Username and password are required'];
        }
        
        // Get user by username or email
        $user = $this->user->getUserByUsernameOrEmail($username);
        
        if (!$user) {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }
        
        // Check if user is active
        if (!$user['is_active']) {
            return ['success' => false, 'message' => 'Account is deactivated'];
        }
        
        // Verify password
        if (password_verify($password, $user['password_hash'])) {
            // Set session variables
            $this->session->set('user_id', $user['id']);
            $this->session->set('username', $user['username']);
            $this->session->set('email', $user['email']);
            $this->session->set('first_name', $user['first_name']);
            $this->session->set('last_name', $user['last_name']);
            $this->session->set('role', $user['role_id']);
            $this->session->set('role_name', $user['role_name']);
            
            // Update last login
            $this->user->updateLastLogin($user['id']);
            
            return ['success' => true, 'message' => 'Login successful', 'role' => $user['role_id']];
        }
        
        return ['success' => false, 'message' => 'Invalid credentials'];
    }
    
    public function logout() {
        $this->session->destroy();
        return ['success' => true, 'message' => 'Logged out successfully'];
    }
    
    public function isLoggedIn() {
        return $this->session->isLoggedIn();
    }
    
    public function getUserRole() {
        return $this->session->get('role');
    }
    
    public function redirectIfLoggedIn($redirectTo = 'dashboard') {
        if ($this->isLoggedIn()) {
            header('Location: ' . BASE_URL . $redirectTo);
            exit();
        }
    }
}