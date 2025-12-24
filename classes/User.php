<?php
// medico/classes/User.php

class User {
    private $conn;
    private $table = 'users';
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getUserByUsernameOrEmail($identifier) {
        $query = "SELECT u.*, r.role_name 
                  FROM " . $this->table . " u 
                  LEFT JOIN roles r ON u.role_id = r.id 
                  WHERE u.username = :identifier OR u.email = :identifier";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':identifier', $identifier);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function getUserById($id) {
        $query = "SELECT u.*, r.role_name 
                  FROM " . $this->table . " u 
                  LEFT JOIN roles r ON u.role_id = r.id 
                  WHERE u.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public function updateLastLogin($id) {
        $query = "UPDATE " . $this->table . " 
                  SET last_login = NOW() 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function getAllUsers() {
        $query = "SELECT u.*, r.role_name 
                  FROM " . $this->table . " u 
                  LEFT JOIN roles r ON u.role_id = r.id 
                  ORDER BY u.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public function createUser($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (username, email, password_hash, first_name, last_name, phone, role_id, specialization, license_number) 
                  VALUES (:username, :email, :password_hash, :first_name, :last_name, :phone, :role_id, :specialization, :license_number)";
        
        $stmt = $this->conn->prepare($query);
        
        // Hash password
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password_hash', $hashed_password);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':role_id', $data['role_id']);
        $stmt->bindParam(':specialization', $data['specialization']);
        $stmt->bindParam(':license_number', $data['license_number']);
        
        return $stmt->execute();
    }
}