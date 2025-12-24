<?php
$title = 'View User';
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
                        <a href="<?php echo BASE_URL; ?>users/manage" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Users</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">View User</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    
    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">User Details</h1>
            <p class="text-gray-600">View user information and activity</p>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo BASE_URL; ?>users/edit/<?php echo $user['id']; ?>" 
               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="<?php echo BASE_URL; ?>users/manage" 
               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>
    
    <!-- User Profile Card -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Column - Profile -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Full Name</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">
                            <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Username</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">
                            @<?php echo htmlspecialchars($user['username']); ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email Address</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">
                            <?php echo htmlspecialchars($user['email']); ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Phone Number</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">
                            <?php echo htmlspecialchars($user['phone'] ?: 'Not provided'); ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Role & Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Role & Status</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Role</label>
                        <p class="mt-2">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                <?php echo $user['role_id'] == 1 ? 'bg-purple-100 text-purple-800' : 
                                          ($user['role_id'] == 2 ? 'bg-blue-100 text-blue-800' : 
                                          ($user['role_id'] == 3 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                <?php echo htmlspecialchars($user['role_name']); ?>
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Account Status</label>
                        <p class="mt-2">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                <?php echo $user['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                        </p>
                    </div>
                    <?php if ($user['specialization']): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Specialization</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">
                            <?php echo htmlspecialchars($user['specialization']); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    <?php if ($user['license_number']): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">License Number</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">
                            <?php echo htmlspecialchars($user['license_number']); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Account Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Account Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">User ID</label>
                        <p class="mt-1 text-gray-900"><?php echo $user['id']; ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Date Created</label>
                        <p class="mt-1 text-gray-900">
                            <?php echo date('F j, Y, g:i a', strtotime($user['created_at'])); ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                        <p class="mt-1 text-gray-900">
                            <?php echo $user['updated_at'] ? date('F j, Y, g:i a', strtotime($user['updated_at'])) : 'Never'; ?>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Last Login</label>
                        <p class="mt-1 text-gray-900">
                            <?php echo $user['last_login'] ? date('F j, Y, g:i a', strtotime($user['last_login'])) : 'Never'; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Actions & Stats -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="<?php echo BASE_URL; ?>users/edit/<?php echo $user['id']; ?>" 
                       class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i> Edit User
                    </a>
                    
                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                        <?php if ($user['is_active']): ?>
                            <a href="<?php echo BASE_URL; ?>users/toggle-status/<?php echo $user['id']; ?>" 
                               class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700"
                               onclick="return confirm('Deactivate this user?')">
                                <i class="fas fa-user-slash mr-2"></i> Deactivate User
                            </a>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL; ?>users/toggle-status/<?php echo $user['id']; ?>" 
                               class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700"
                               onclick="return confirm('Activate this user?')">
                                <i class="fas fa-user-check mr-2"></i> Activate User
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?php echo BASE_URL; ?>users/delete/<?php echo $user['id']; ?>" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700"
                           onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                            <i class="fas fa-trash mr-2"></i> Delete User
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- User Avatar -->
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <div class="h-32 w-32 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl font-bold text-gray-600">
                        <?php echo strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)); ?>
                    </span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">
                    <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                </h3>
                <p class="text-gray-600">@<?php echo htmlspecialchars($user['username']); ?></p>
                
                <div class="mt-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        <?php echo $user['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                        <i class="fas fa-circle mr-1" style="font-size: 8px;"></i>
                        <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../views/layouts/main.php';
?>