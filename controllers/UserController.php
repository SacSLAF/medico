<?php
// medico/controllers/UserController.php

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/includes/Auth.php';
require_once dirname(__DIR__) . '/includes/Session.php';
require_once dirname(__DIR__) . '/config/Database.php';

class UserController
{
    private $auth;
    private $session;
    private $db;

    public function __construct()
    {
        $this->auth = new Auth();
        $this->session = new Session();
        $this->db = (new Database())->connect();

        // Require login and super admin role
        if (!$this->auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }

        if (!$this->session->hasRole(ROLE_SUPER_ADMIN)) {
            $this->session->setFlash('error', 'Access denied. Super Admin only.');
            header('Location: ' . BASE_URL . 'dashboard');
            exit();
        }
    }

    // Show add user form
    public function add()
    {
        // Get all roles for dropdown
        $roles = $this->getAllRoles();

        $title = 'Add New User';
        $showNavbar = true;
        ob_start();
        include dirname(__DIR__) . '/views/users/add.php';
    }

    // Process add user form
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'users/add');
            exit();
        }

        // Validate input
        $errors = [];

        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'role_id' => (int)($_POST['role_id'] ?? 0),
            'specialization' => trim($_POST['specialization'] ?? ''),
            'license_number' => trim($_POST['license_number'] ?? '')
        ];

        // Validation
        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        } elseif (strlen($data['username']) < 3) {
            $errors['username'] = 'Username must be at least 3 characters';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        } elseif ($data['password'] !== $data['confirm_password']) {
            $errors['confirm_password'] = 'Passwords do not match';
        }

        if (empty($data['first_name'])) {
            $errors['first_name'] = 'First name is required';
        }

        if (empty($data['last_name'])) {
            $errors['last_name'] = 'Last name is required';
        }

        if ($data['role_id'] < 1 || $data['role_id'] > 4) {
            $errors['role_id'] = 'Invalid role selected';
        }

        // Check if username or email already exists
        if (empty($errors)) {
            if ($this->checkUserExists($data['username'], $data['email'])) {
                $errors['general'] = 'Username or email already exists';
            }
        }

        // If validation passes
        if (empty($errors)) {
            try {
                $this->createUser($data);
                $this->session->setFlash('success', 'User created successfully!');
                header('Location: ' . BASE_URL . 'users/manage');
                exit();
            } catch (Exception $e) {
                $errors['general'] = 'Error creating user: ' . $e->getMessage();
            }
        }

        // If validation fails, show form with errors
        $roles = $this->getAllRoles();
        $title = 'Add New User';
        $showNavbar = true;

        // Pass data and errors to view
        include dirname(__DIR__) . '/views/users/add.php';
    }

    // Show manage users page
    public function manage()
    {
        // Get all users
        $users = $this->getAllUsers();

        $title = 'Manage Users';
        $showNavbar = true;

        ob_start();
        include dirname(__DIR__) . '/views/users/manage.php';
    }
    public function view($id)
    {
        $user = $this->getUserById($id);

        if (!$user) {
            $this->session->setFlash('error', 'User not found.');
            header('Location: ' . BASE_URL . 'users/manage');
            exit();
        }

        $title = 'View User - ' . $user['first_name'] . ' ' . $user['last_name'];
        $showNavbar = true;

        include dirname(__DIR__) . '/views/users/view.php';
    }

    // Show edit user form
    public function edit($id)
    {
        $user = $this->getUserById($id);

        if (!$user) {
            $this->session->setFlash('error', 'User not found.');
            header('Location: ' . BASE_URL . 'users/manage');
            exit();
        }

        // Don't allow editing yourself (for demo)
        if ($user['id'] == $_SESSION['user_id']) {
            $this->session->setFlash('error', 'You cannot edit your own profile from here.');
            header('Location: ' . BASE_URL . 'users/manage');
            exit();
        }

        $roles = $this->getAllRoles();
        $title = 'Edit User - ' . $user['first_name'] . ' ' . $user['last_name'];
        $showNavbar = true;

        include dirname(__DIR__) . '/views/users/edit.php';
    }

    // Update user
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'users/edit/' . $id);
            exit();
        }

        $user = $this->getUserById($id);
        if (!$user) {
            $this->session->setFlash('error', 'User not found.');
            header('Location: ' . BASE_URL . 'users/manage');
            exit();
        }

        $errors = [];
        $data = $this->getFormData();

        // Don't require password for update unless provided
        $validatePassword = !empty($data['password']);

        // Validation
        $errors = $this->validateUserData($data, $validatePassword, $id);

        if (empty($errors)) {
            try {
                $this->updateUser($id, $data);
                $this->session->setFlash('success', 'User updated successfully!');
                header('Location: ' . BASE_URL . 'users/manage');
                exit();
            } catch (Exception $e) {
                $errors['general'] = 'Error updating user: ' . $e->getMessage();
            }
        }

        // Show edit form with errors
        $roles = $this->getAllRoles();
        $title = 'Edit User - ' . $user['first_name'] . ' ' . $user['last_name'];
        $showNavbar = true;

        include dirname(__DIR__) . '/views/users/edit.php';
    }

    // Toggle user active status
    public function toggleStatus($id)
    {
        $user = $this->getUserById($id);

        if (!$user) {
            $this->session->setFlash('error', 'User not found.');
            header('Location: ' . BASE_URL . 'users/manage');
            exit();
        }

        if ($user['id'] == $_SESSION['user_id']) {
            $this->session->setFlash('error', 'You cannot change your own status.');
            header('Location: ' . BASE_URL . 'users/manage');
            exit();
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        $statusText = $newStatus ? 'activated' : 'deactivated';

        try {
            $this->updateUserStatus($id, $newStatus);
            $this->session->setFlash('success', "User $statusText successfully!");
        } catch (Exception $e) {
            $this->session->setFlash('error', 'Error updating user status: ' . $e->getMessage());
        }

        header('Location: ' . BASE_URL . 'users/manage');
        exit();
    }

    // Delete user
    public function delete($id)
    {
        $user = $this->getUserById($id);

        if (!$user) {
            $this->session->setFlash('error', 'User not found.');
            header('Location: ' . BASE_URL . 'users/manage');
            exit();
        }

        if ($user['id'] == $_SESSION['user_id']) {
            $this->session->setFlash('error', 'You cannot delete your own account.');
            header('Location: ' . BASE_URL . 'users/manage');
            exit();
        }

        try {
            $this->deleteUser($id);
            $this->session->setFlash('success', 'User deleted successfully!');
        } catch (Exception $e) {
            $this->session->setFlash('error', 'Error deleting user: ' . $e->getMessage());
        }

        header('Location: ' . BASE_URL . 'users/manage');
        exit();
    }

    // ============ HELPER METHODS ============

    private function getFormData()
    {
        return [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'role_id' => (int)($_POST['role_id'] ?? 0),
            'specialization' => trim($_POST['specialization'] ?? ''),
            'license_number' => trim($_POST['license_number'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
    }

    private function validateUserData($data, $validatePassword = true, $excludeUserId = null)
    {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        } elseif (strlen($data['username']) < 3) {
            $errors['username'] = 'Username must be at least 3 characters';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if ($validatePassword) {
            if (empty($data['password'])) {
                $errors['password'] = 'Password is required';
            } elseif (strlen($data['password']) < 6) {
                $errors['password'] = 'Password must be at least 6 characters';
            } elseif ($data['password'] !== $data['confirm_password']) {
                $errors['confirm_password'] = 'Passwords do not match';
            }
        }

        if (empty($data['first_name'])) {
            $errors['first_name'] = 'First name is required';
        }

        if (empty($data['last_name'])) {
            $errors['last_name'] = 'Last name is required';
        }

        if ($data['role_id'] < 1 || $data['role_id'] > 4) {
            $errors['role_id'] = 'Invalid role selected';
        }

        // Check if username or email already exists (excluding current user for updates)
        if (empty($errors)) {
            if ($this->checkUserExists($data['username'], $data['email'], $excludeUserId)) {
                $errors['general'] = 'Username or email already exists';
            }
        }

        return $errors;
    }

    private function getAllRoles()
    {
        $stmt = $this->db->query("SELECT * FROM roles ORDER BY id");
        return $stmt->fetchAll();
    }

    private function checkUserExists($username, $email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE (username = ? OR email = ?)";
        $params = [$username, $email];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }

    private function createUser($data)
    {
        $query = "INSERT INTO users 
                  (username, email, password_hash, first_name, last_name, phone, 
                   role_id, specialization, license_number, is_active, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->db->prepare($query);

        // Hash password if provided
        $hashed_password = !empty($data['password'])
            ? password_hash($data['password'], PASSWORD_DEFAULT)
            : '';

        $stmt->execute([
            $data['username'],
            $data['email'],
            $hashed_password,
            $data['first_name'],
            $data['last_name'],
            $data['phone'],
            $data['role_id'],
            $data['specialization'],
            $data['license_number'],
            $data['is_active'] ?? 1
        ]);

        return $this->db->lastInsertId();
    }

    private function getAllUsers()
    {
        $stmt = $this->db->query("
            SELECT u.*, r.role_name 
            FROM users u 
            LEFT JOIN roles r ON u.role_id = r.id 
            ORDER BY u.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    private function getUserById($id)
    {
        $stmt = $this->db->prepare("
            SELECT u.*, r.role_name 
            FROM users u 
            LEFT JOIN roles r ON u.role_id = r.id 
            WHERE u.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    private function updateUser($id, $data)
    {
        // Build update query dynamically based on provided fields
        $fields = [];
        $params = [];

        if (!empty($data['username'])) {
            $fields[] = 'username = ?';
            $params[] = $data['username'];
        }

        if (!empty($data['email'])) {
            $fields[] = 'email = ?';
            $params[] = $data['email'];
        }

        if (!empty($data['password'])) {
            $fields[] = 'password_hash = ?';
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (!empty($data['first_name'])) {
            $fields[] = 'first_name = ?';
            $params[] = $data['first_name'];
        }

        if (!empty($data['last_name'])) {
            $fields[] = 'last_name = ?';
            $params[] = $data['last_name'];
        }

        $fields[] = 'phone = ?';
        $params[] = $data['phone'];

        $fields[] = 'role_id = ?';
        $params[] = $data['role_id'];

        $fields[] = 'specialization = ?';
        $params[] = $data['specialization'];

        $fields[] = 'license_number = ?';
        $params[] = $data['license_number'];

        $fields[] = 'is_active = ?';
        $params[] = $data['is_active'];

        $fields[] = 'updated_at = NOW()';

        $params[] = $id; // For WHERE clause

        $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    private function updateUserStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE users SET is_active = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    private function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Doctor management 
    public function doctors()
    {
        // Get only doctors
        $doctors = $this->getDoctors();

        $title = 'Manage Doctors';
        $showNavbar = true;

        include dirname(__DIR__) . '/views/users/doctors.php';
    }

    // Add this helper method to UserController
    private function getDoctors()
    {
        $stmt = $this->db->prepare("
        SELECT u.*, r.role_name 
        FROM users u 
        LEFT JOIN roles r ON u.role_id = r.id 
        WHERE u.role_id = ? 
        ORDER BY u.created_at DESC
    ");
        $stmt->execute([ROLE_DOCTOR]);
        return $stmt->fetchAll();
    }
}
