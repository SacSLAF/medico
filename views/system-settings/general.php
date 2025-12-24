<?php
$title = 'General Settings';
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
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <a href="<?php echo BASE_URL; ?>system-settings" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">
                            System Settings
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">General Settings</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">General Settings</h1>
                <p class="text-gray-600">Configure your system's general preferences</p>
            </div>
            <a href="<?php echo BASE_URL; ?>system-settings" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i> Back to Settings
            </a>
        </div>
    </div>
    
    <!-- Settings Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="<?php echo BASE_URL; ?>system-settings/general">
            <div class="space-y-6">
                <!-- Site Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Site Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                            <input type="text" name="site_name" value="<?php echo $settings['site_name'] ?? 'Medico System'; ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Site Title</label>
                            <input type="text" name="site_title" value="<?php echo $settings['site_title'] ?? 'Hospital Management System'; ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                
                <!-- Date & Time -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Date & Time</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                            <select name="timezone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="UTC" <?php echo ($settings['timezone'] ?? 'UTC') == 'UTC' ? 'selected' : ''; ?>>UTC</option>
                                <option value="America/New_York" <?php echo ($settings['timezone'] ?? '') == 'America/New_York' ? 'selected' : ''; ?>>Eastern Time</option>
                                <option value="America/Chicago" <?php echo ($settings['timezone'] ?? '') == 'America/Chicago' ? 'selected' : ''; ?>>Central Time</option>
                                <option value="America/Denver" <?php echo ($settings['timezone'] ?? '') == 'America/Denver' ? 'selected' : ''; ?>>Mountain Time</option>
                                <option value="America/Los_Angeles" <?php echo ($settings['timezone'] ?? '') == 'America/Los_Angeles' ? 'selected' : ''; ?>>Pacific Time</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                            <select name="date_format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="Y-m-d" <?php echo ($settings['date_format'] ?? 'Y-m-d') == 'Y-m-d' ? 'selected' : ''; ?>>YYYY-MM-DD</option>
                                <option value="d/m/Y" <?php echo ($settings['date_format'] ?? '') == 'd/m/Y' ? 'selected' : ''; ?>>DD/MM/YYYY</option>
                                <option value="m/d/Y" <?php echo ($settings['date_format'] ?? '') == 'm/d/Y' ? 'selected' : ''; ?>>MM/DD/YYYY</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Time Format</label>
                            <select name="time_format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="H:i" <?php echo ($settings['time_format'] ?? 'H:i') == 'H:i' ? 'selected' : ''; ?>>24-hour (14:30)</option>
                                <option value="h:i A" <?php echo ($settings['time_format'] ?? '') == 'h:i A' ? 'selected' : ''; ?>>12-hour (2:30 PM)</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- System Preferences -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">System Preferences</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Items Per Page</label>
                            <input type="number" name="items_per_page" value="<?php echo $settings['items_per_page'] ?? '20'; ?>" 
                                   min="5" max="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Default Language</label>
                            <select name="default_language" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="en" <?php echo ($settings['default_language'] ?? 'en') == 'en' ? 'selected' : ''; ?>>English</option>
                                <option value="es" <?php echo ($settings['default_language'] ?? '') == 'es' ? 'selected' : ''; ?>>Spanish</option>
                                <option value="fr" <?php echo ($settings['default_language'] ?? '') == 'fr' ? 'selected' : ''; ?>>French</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- System Features -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">System Features</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="checkbox" id="enable_registration" name="enable_registration" value="1" 
                                   <?php echo ($settings['enable_registration'] ?? '0') == '1' ? 'checked' : ''; ?>
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="enable_registration" class="ml-2 block text-sm text-gray-700">
                                Enable User Registration
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" 
                                   <?php echo ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : ''; ?>
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="maintenance_mode" class="ml-2 block text-sm text-gray-700">
                                Enable Maintenance Mode
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="pt-6 border-t">
                    <div class="flex justify-end space-x-3">
                        <a href="<?php echo BASE_URL; ?>system-settings" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../views/layouts/main.php';
?>