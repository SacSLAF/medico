<nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="<?php echo BASE_URL; ?>dashboard" class="flex items-center space-x-2">
                    <div class="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white"></i>
                    </div>
                    <span class="font-bold text-xl text-gray-800"><?php echo APP_NAME; ?></span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-4">
                <span class="text-gray-600">
                    <i class="fas fa-user-circle mr-1"></i>
                    <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>
                    <span class="ml-2 px-2 py-1 text-xs rounded-full 
                        <?php echo $_SESSION['role'] == 1 ? 'bg-purple-100 text-purple-800' : 
                                  ($_SESSION['role'] == 2 ? 'bg-blue-100 text-blue-800' : 
                                  ($_SESSION['role'] == 3 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                        <?php echo htmlspecialchars($_SESSION['role_name']); ?>
                    </span>
                </span>
                
                <!-- Notifications -->
                <div class="relative">
                    <button class="p-2 text-gray-600 hover:text-blue-600">
                        <i class="fas fa-bell"></i>
                        <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                    </button>
                </div>
                
                <!-- User Menu -->
                <div class="relative">
                    <button id="userMenuButton" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                        <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    
                    <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Profile
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </a>
                        <div class="border-t my-1"></div>
                        <a href="<?php echo BASE_URL; ?>auth/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobileMenuButton" class="text-gray-600 hover:text-blue-600">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<script>
// User menu toggle
document.getElementById('userMenuButton').addEventListener('click', function() {
    document.getElementById('userMenu').classList.toggle('hidden');
});

// Close menu when clicking outside
document.addEventListener('click', function(event) {
    const userMenu = document.getElementById('userMenu');
    const userMenuButton = document.getElementById('userMenuButton');
    
    if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
        userMenu.classList.add('hidden');
    }
});
</script>