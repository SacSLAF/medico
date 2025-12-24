<?php
$title = 'System Settings';
$showNavbar = true;
ob_start();
?>

<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?php echo BASE_URL; ?>dashboard" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">System Settings</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">System Settings</h1>
                <p class="text-gray-600">Configure and manage your system preferences</p>
            </div>
        </div>
    </div>
    
    <!-- Settings Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- General Settings -->
        <a href="<?php echo BASE_URL; ?>system-settings/general" 
           class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border border-gray-200">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-cog text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">General Settings</h3>
                    <p class="text-gray-600 text-sm mt-1">Site configuration and preferences</p>
                </div>
            </div>
        </a>
        
        <!-- Email Settings -->
        <a href="<?php echo BASE_URL; ?>system-settings/email" 
           class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border border-gray-200">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-envelope text-green-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Email Settings</h3>
                    <p class="text-gray-600 text-sm mt-1">SMTP configuration and email setup</p>
                </div>
            </div>
        </a>
        
        <!-- Clinic Settings -->
        <a href="<?php echo BASE_URL; ?>system-settings/clinic" 
           class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border border-gray-200">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-hospital text-purple-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Clinic Settings</h3>
                    <p class="text-gray-600 text-sm mt-1">Clinic information and working hours</p>
                </div>
            </div>
        </a>
        
        <!-- User Management -->
        <a href="<?php echo BASE_URL; ?>system-settings/usersettings" 
           class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border border-gray-200">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-users text-yellow-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">User Management</h3>
                    <p class="text-gray-600 text-sm mt-1">Password policies and security settings</p>
                </div>
            </div>
        </a>
        
        <!-- Backup & Maintenance -->
        <a href="<?php echo BASE_URL; ?>system-settings/backup" 
           class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border border-gray-200">
            <div class="flex items-center">
                <div class="bg-red-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-database text-red-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Backup & Maintenance</h3>
                    <p class="text-gray-600 text-sm mt-1">Database backup and system maintenance</p>
                </div>
            </div>
        </a>
        
        <!-- System Information -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex items-center mb-4">
                <div class="bg-gray-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-info-circle text-gray-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">System Information</h3>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">PHP Version:</span>
                    <span class="font-medium"><?php echo $systemInfo['php_version']; ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">MySQL Version:</span>
                    <span class="font-medium"><?php echo $systemInfo['mysql_version']; ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Server:</span>
                    <span class="font-medium"><?php echo $systemInfo['server_software']; ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Max Upload Size:</span>
                    <span class="font-medium"><?php echo $systemInfo['upload_max_filesize']; ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Database Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Database Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600 mb-2"><?php echo $databaseInfo['size_mb'] ?? '0'; ?> MB</div>
                <p class="text-sm text-gray-600">Database Size</p>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600 mb-2"><?php echo $databaseInfo['table_count'] ?? '0'; ?></div>
                <p class="text-sm text-gray-600">Total Tables</p>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600 mb-2"><?php echo $databaseInfo['database_name'] ?? 'medico'; ?></div>
                <p class="text-sm text-gray-600">Database Name</p>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="<?php echo BASE_URL; ?>system-settings/backup" 
                   class="flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-md transition">
                    <div class="flex items-center">
                        <i class="fas fa-download text-blue-600 mr-3"></i>
                        <span class="font-medium text-gray-800">Create Backup Now</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>
                <a href="<?php echo BASE_URL; ?>dashboard" 
                   class="flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-md transition">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt text-green-600 mr-3"></i>
                        <span class="font-medium text-gray-800">Go to Dashboard</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>
                <a href="<?php echo BASE_URL; ?>reports" 
                   class="flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-md transition">
                    <div class="flex items-center">
                        <i class="fas fa-chart-bar text-purple-600 mr-3"></i>
                        <span class="font-medium text-gray-800">View Reports</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">System Status</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Disk Usage</span>
                        <span class="text-sm font-medium text-gray-700"><?php echo round($systemStatus['disk_percent'], 1); ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo $systemStatus['disk_percent']; ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Memory Usage</span>
                        <span class="text-sm font-medium text-gray-700"><?php echo round(($systemStatus['memory_usage'] / 1024 / 1024), 2); ?> MB</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
                <div class="pt-3 border-t">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        All systems operational
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../views/layouts/main.php';
?>