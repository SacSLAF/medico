<?php
// patient-management-system/setup-data.php

echo "<h2>Medico - Database Setup</h2>";

try {
    // Connect to your medico database directly
    $pdo = new PDO('mysql:host=localhost;dbname=medico', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✓ Connected to medico database successfully</p>";


    
    // Create default users (password: password)
    echo "<p>Creating default users...</p>";
    $hashed_password = password_hash('password', PASSWORD_DEFAULT);
    
    $userStmt = $pdo->prepare("
        INSERT INTO users (username, email, password_hash, first_name, last_name, role_id, is_active) 
        VALUES (:username, :email, :password, :first_name, :last_name, :role_id, 1)
        ON DUPLICATE KEY UPDATE 
            email=VALUES(email),
            first_name=VALUES(first_name),
            last_name=VALUES(last_name)
    ");
    
    $users = [
        ['admin', 'admin@hospital.com', $hashed_password, 'System', 'Administrator', 1],
        ['doctor', 'doctor@hospital.com', $hashed_password, 'John', 'Smith', 2],
        ['receptionist', 'reception@hospital.com', $hashed_password, 'Sarah', 'Johnson', 3],
        ['pharmacist', 'pharmacy@hospital.com', $hashed_password, 'Mike', 'Williams', 4]
    ];
    
    foreach ($users as $user) {
        $userStmt->execute([
            ':username' => $user[0],
            ':email' => $user[1],
            ':password' => $hashed_password,
            ':first_name' => $user[3],
            ':last_name' => $user[4],
            ':role_id' => $user[5]
        ]);
    }
    
    echo "<p style='color: green;'>✓ Default users created successfully!</p>";
    
    // Add some sample medicines
    echo "<p>Adding sample medicines...</p>";
    
    $medicines = [
        ['MED001', 'Paracetamol', 'Acetaminophen', 'Tablet', 5.00, 1000],
        ['MED002', 'Amoxicillin', 'Amoxicillin Trihydrate', 'Capsule', 15.50, 500],
        ['MED003', 'Ibuprofen', 'Ibuprofen', 'Tablet', 8.75, 750],
        ['MED004', 'Cetirizine', 'Cetirizine HCl', 'Tablet', 12.25, 300],
        ['MED005', 'Omeprazole', 'Omeprazole', 'Capsule', 25.00, 200]
    ];
    
    $medStmt = $pdo->prepare("
        INSERT INTO medicines (medicine_code, name, generic_name, category, unit_price, stock_quantity) 
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE name=VALUES(name)
    ");
    
    foreach ($medicines as $medicine) {
        $medStmt->execute($medicine);
    }
    echo "<p style='color: green;'>✓ Sample medicines added</p>";
    
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 20px 0;'>
            <h3 style='margin-top: 0;'>✅ Setup Complete!</h3>
            <p><strong>Login Credentials:</strong></p>
            <ul>
                <li><strong>Super Admin:</strong> admin / Admin@123</li>
                <li><strong>Doctor:</strong> doctor / Admin@123</li>
                <li><strong>Receptionist:</strong> receptionist / Admin@123</li>
                <li><strong>Pharmacist:</strong> pharmacist / Admin@123</li>
            </ul>
            <p><strong>Access URL:</strong> http://localhost/medico/public/</p>
            <p><em style='color: #666;'>Delete this file after setup for security.</em></p>
          </div>";
    
} catch(PDOException $e) {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; color: #721c24;'>
            <strong>Error:</strong> " . $e->getMessage() . "
            <p>Check if:</p>
            <ul>
                <li>Database 'medico' exists</li>
                <li>All tables are created (run the SQL schema first)</li>
                <li>MySQL credentials are correct</li>
                <li>MySQL server is running</li>
            </ul>
          </div>";
}
?>