<?php
// views/partials/navbar.php
$currentUser = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User';
$currentRole = isset($_SESSION['role_name']) ? $_SESSION['role_name'] : 'User';
?>

<!-- Main Navigation -->
<nav class="bg-white shadow-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Brand -->
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo BASE_URL; ?>dashboard" class="flex items-center">
                        <div class="h-8 w-8 bg-blue-600 rounded-md flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white"></i>
                        </div>
                        <span class="ml-2 text-xl font-bold text-gray-800"><?php echo APP_NAME; ?></span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:ml-6 md:flex md:space-x-4">
                    <!-- <a href="<?php echo BASE_URL; ?>dashboard" 
                       class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'; ?> px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a> -->

                    <?php if ($_SESSION['role'] == ROLE_SUPER_ADMIN || $_SESSION['role'] == ROLE_ADMIN): ?>
                        <!-- <a href="<?php echo BASE_URL; ?>users" 
                       class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'users') !== false) ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'; ?> px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-users mr-1"></i> Users
                    </a> -->
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] == ROLE_DOCTOR || $_SESSION['role'] == ROLE_RECEPTIONIST): ?>
                        <!-- <a href="<?php echo BASE_URL; ?>appointments" 
                       class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'appointments') !== false) ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'; ?> px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-calendar-check mr-1"></i> Appointments
                    </a> -->
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] == ROLE_SUPER_ADMIN || $_SESSION['role'] == ROLE_DOCTOR || $_SESSION['role'] == ROLE_RECEPTIONIST): ?>
                        <!-- <a href="<?php echo BASE_URL; ?>reports" 
                       class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'reports') !== false) ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'; ?> px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-chart-bar mr-1"></i> Reports
                    </a> -->
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] == ROLE_SUPER_ADMIN): ?>
                        <!-- <a href="<?php echo BASE_URL; ?>system-settings" 
                       class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'system-settings') !== false) ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'; ?> px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-cog mr-1"></i> Settings
                    </a> -->
                    <?php endif; ?>
                </div>
            </div>

            <!-- User menu and mobile menu button -->
            <div class="flex items-center">
                <!-- User Info (Desktop) -->
                <div class="hidden md:flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($currentUser); ?></p>
                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($currentRole); ?></p>
                    </div>

                    <!-- User Dropdown -->
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center focus:outline-none">
                            <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <i class="fas fa-chevron-down ml-1 text-gray-400 text-xs"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200">
                            <a href="<?php echo BASE_URL; ?>profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-circle mr-2"></i> My Profile
                            </a>
                            <a href="<?php echo BASE_URL; ?>auth/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Sign out
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button id="menu-button" onclick="toggleMobileMenu()" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu (hidden by default) -->
    <!-- <div id="mobile-menu" class="mobile-menu md:hidden fixed inset-0 z-40 bg-white h-screen w-64 shadow-lg"> -->
    <!-- <div id="mobile-menu" class="mobile-menu md:hidden fixed top-0 left-0 z-40 bg-white h-full w-64 shadow-lg"> -->
    <div id="mobile-menu" class="mobile-menu md:hidden fixed top-0 left-0 z-40 bg-white h-full w-64 shadow-lg hidden">
        <div class="px-4 pt-4 pb-3 space-y-1">
            <!-- Mobile User Info -->
            <div class="px-3 py-4 border-b border-gray-200 mb-4">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($currentUser); ?></p>
                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($currentRole); ?></p>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation Links -->
            <a href="<?php echo BASE_URL; ?>dashboard"
                class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'; ?> block px-3 py-3 rounded-md text-base font-medium transition">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>

            <?php if ($_SESSION['role'] == ROLE_SUPER_ADMIN || $_SESSION['role'] == ROLE_ADMIN): ?>
                <a href="<?php echo BASE_URL; ?>users"
                    class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'users') !== false) ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'; ?> block px-3 py-3 rounded-md text-base font-medium transition">
                    <i class="fas fa-users mr-3"></i> Users
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['role'] == ROLE_DOCTOR || $_SESSION['role'] == ROLE_RECEPTIONIST): ?>
                <a href="<?php echo BASE_URL; ?>appointments"
                    class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'appointments') !== false) ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'; ?> block px-3 py-3 rounded-md text-base font-medium transition">
                    <i class="fas fa-calendar-check mr-3"></i> Appointments
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['role'] == ROLE_SUPER_ADMIN || $_SESSION['role'] == ROLE_DOCTOR || $_SESSION['role'] == ROLE_RECEPTIONIST): ?>
                <a href="<?php echo BASE_URL; ?>reports"
                    class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'reports') !== false) ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'; ?> block px-3 py-3 rounded-md text-base font-medium transition">
                    <i class="fas fa-chart-bar mr-3"></i> Reports
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['role'] == ROLE_SUPER_ADMIN): ?>
                <a href="<?php echo BASE_URL; ?>system-settings"
                    class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'system-settings') !== false) ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100'; ?> block px-3 py-3 rounded-md text-base font-medium transition">
                    <i class="fas fa-cog mr-3"></i> Settings
                </a>
            <?php endif; ?>

            <div class="pt-4 border-t border-gray-200 mt-4">
                <a href="<?php echo BASE_URL; ?>profile" class="block px-3 py-3 text-gray-700 hover:bg-gray-100 rounded-md">
                    <i class="fas fa-user-circle mr-3"></i> My Profile
                </a>
                <a href="<?php echo BASE_URL; ?>auth/logout" class="block px-3 py-3 text-gray-700 hover:bg-gray-100 rounded-md">
                    <i class="fas fa-sign-out-alt mr-3"></i> Sign out
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    // Toggle user dropdown
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');

        if (userMenuButton && userDropdown) {
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                userDropdown.classList.add('hidden');
            });

            // Prevent dropdown from closing when clicking inside
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>