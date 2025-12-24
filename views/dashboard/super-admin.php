<?php
$title = 'Super Admin Dashboard';
$showNavbar = true;
ob_start();
?>

<div class="container mx-auto px-4 py-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>!</h1>
        <p class="text-gray-600">Super Admin Dashboard</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Users</p>
                    <p class="text-2xl font-bold"><?php echo $stats['total_users']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-user-injured text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Patients</p>
                    <p class="text-2xl font-bold"><?php echo $stats['total_patients']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Appointments</p>
                    <p class="text-2xl font-bold"><?php echo $stats['total_appointments']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-prescription text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Prescriptions</p>
                    <p class="text-2xl font-bold"><?php echo $stats['total_prescriptions']; ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="<?php echo BASE_URL; ?>users/add" class="bg-blue-50 hover:bg-blue-100 text-blue-700 p-4 rounded-lg text-center transition">
                <i class="fas fa-user-plus text-2xl mb-2"></i>
                <p>Add User</p>
            </a>
            <a href="<?php echo BASE_URL; ?>users/doctors" class="bg-green-50 hover:bg-green-100 text-green-700 p-4 rounded-lg text-center transition">
                <i class="fas fa-user-md text-2xl mb-2"></i>
                <p>Manage Doctors</p>
            </a>
            <a href="<?php echo BASE_URL; ?>reports" class="bg-purple-50 hover:bg-purple-100 text-purple-700 p-4 rounded-lg text-center transition">
                <i class="fas fa-chart-bar text-2xl mb-2"></i>
                <p>View Reports</p>
            </a>
            <a href="<?php echo BASE_URL; ?>system-settings" class="bg-red-50 hover:bg-red-100 text-red-700 p-4 rounded-lg text-center transition">
                <i class="fas fa-cog text-2xl mb-2"></i>
                <p>System Settings</p>
            </a>
        </div>
    </div>
    
    <!-- Recent Users -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-xl font-bold text-gray-800">Recent Users</h2>
        </div>
        <div class="p-6">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Role</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentUsers)): ?>
                        <?php foreach ($recentUsers as $user): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                            <td class="px-4 py-3"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    <?php echo $user['role_id'] == 1 ? 'bg-purple-100 text-purple-800' : 
                                              ($user['role_id'] == 2 ? 'bg-blue-100 text-blue-800' : 
                                              ($user['role_id'] == 3 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                    <?php echo htmlspecialchars($user['role_name']); ?>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full <?php echo $user['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                    <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../views/layouts/main.php';
?>