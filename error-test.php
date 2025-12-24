<?php
// simple-login.php
session_start();

// Simple authentication
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Simple hardcoded check (temporary)
    if ($username === 'admin' && $password === 'Admin@123') {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = 'admin';
        $_SESSION['first_name'] = 'System';
        $_SESSION['last_name'] = 'Administrator';
        $_SESSION['role'] = 1;
        $_SESSION['role_name'] = 'Super Admin';
        
        header('Location: public/index.php?url=dashboard');
        exit();
    } else {
        $error = "Invalid credentials";
    }
}

// If already logged in, redirect to dashboard
if (!empty($_SESSION['user_id'])) {
    header('Location: public/index.php?url=dashboard');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6">Login to Medico</h2>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" class="w-full p-2 border rounded" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" class="w-full p-2 border rounded" required>
                </div>
                
                <button type="submit" name="login" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                    Login
                </button>
            </form>
            
            <div class="mt-4 text-sm text-gray-600">
                <p>Use: admin / Admin@123</p>
            </div>
        </div>
    </div>
</body>
</html>