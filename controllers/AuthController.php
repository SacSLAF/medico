<?php
// medico/controllers/AuthController.php

require_once '../includes/Auth.php';
require_once '../includes/Session.php';



class AuthController
{
    private $auth;
    private $session;

    public function __construct()
    {
        $this->auth = new Auth();
        $this->session = new Session();
    }

    public function login()
    {
        // Check if user is already logged in
        if ($this->auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit();
        }

        // Get any flash error message
        $error = $this->session->getFlash('error');

        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $result = $this->auth->login($username, $password);

            if ($result['success']) {
                // Store success message
                $this->session->setFlash('success', 'Login successful! Welcome.');

                // Redirect to dashboard
                header('Location: ' . BASE_URL . 'dashboard');
                exit();
            } else {
                // Store error as flash message and redirect
                $this->session->setFlash('error', $result['message']);
                header('Location: ' . BASE_URL . 'auth/login');
                exit();
            }
        }

        // Load login view
        require_once '../views/auth/login.php';
    }

    public function logout()
    {
        $result = $this->auth->logout();
        $this->session->setFlash('success', 'Logged out successfully.');
        header('Location: ' . BASE_URL . 'auth/login');
        exit();
    }

    public function register()
    {
        // For now, just show registration form
        // In next steps, we'll implement registration
        require_once '../views/auth/register.php';
    }
}
