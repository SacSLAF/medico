<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' | ' . APP_NAME : APP_NAME; ?></title>
    
    <!-- Tailwind CSS -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
     <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/tailwind.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        .flash-message {
            animation: fadeOut 5s forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; display: none; }
        }
    </style>
    
    <!-- <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        danger: '#EF4444',
                        warning: '#F59E0B',
                        dark: '#1F2937'
                    }
                }
            }
        }
    </script> -->
</head>
<body class="bg-gray-50">
    <?php 
    if (isset($showNavbar) && $showNavbar && isset($_SESSION['user_id'])) {
        include '../views/partials/navbar.php';
    }
    ?>
    
    <main class="min-h-screen">
        <?php 
        // Display flash messages
        if (isset($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $type => $message) {
                $bgColor = $type == 'success' ? 'bg-green-100 border-green-400 text-green-700' : 
                           ($type == 'error' ? 'bg-red-100 border-red-400 text-red-700' : 
                           'bg-blue-100 border-blue-400 text-blue-700');
                echo "<div class='flash-message $bgColor border px-4 py-3 rounded mx-4 mt-4'>" . 
                     htmlspecialchars($message) . "</div>";
                unset($_SESSION['flash'][$type]);
            }
        }
        ?>
        
        <?php echo $content ?? ''; ?>
    </main>
    
    <script>
        // Auto-hide flash messages
        setTimeout(() => {
            document.querySelectorAll('.flash-message').forEach(msg => {
                msg.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>