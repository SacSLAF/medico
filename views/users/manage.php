<?php
$title = 'Manage Users';
$showNavbar = true;
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Manage Users</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manage Users</h1>
            <p class="text-gray-600">View and manage all system users</p>
        </div>
        <a href="<?php echo BASE_URL; ?>users/add"
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
            <i class="fas fa-user-plus mr-2"></i> Add New User
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">All Users</h2>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search users..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Roles</option>
                    <option value="1">Super Admin</option>
                    <option value="2">Doctor</option>
                    <option value="3">Receptionist</option>
                    <option value="4">Pharmacist</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <?php if ($user['profile_image']): ?>
                                            <img class="h-10 w-10 rounded-full" src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="">
                                        <?php else: ?>
                                            <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                <span class="text-gray-600 font-medium">
                                                    <?php echo strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)); ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            @<?php echo htmlspecialchars($user['username']); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php echo $user['role_id'] == 1 ? 'bg-purple-100 text-purple-800' : ($user['role_id'] == 2 ? 'bg-blue-100 text-blue-800' : ($user['role_id'] == 3 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                    <?php echo htmlspecialchars($user['role_name']); ?>
                                </span>
                                <?php if ($user['specialization']): ?>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <?php echo htmlspecialchars($user['specialization']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($user['email']); ?></div>
                                <?php if ($user['phone']): ?>
                                    <div class="text-sm text-gray-500"><?php echo htmlspecialchars($user['phone']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($user['is_active']): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo date('M d, Y', strtotime($user['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="<?php echo BASE_URL; ?>users/edit/<?php echo $user['id']; ?>"
                                        class="text-blue-600 hover:text-blue-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>users/view/<?php echo $user['id']; ?>"
                                        class="text-green-600 hover:text-green-900" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                        <?php if ($user['is_active']): ?>
                                            <a href="<?php echo BASE_URL; ?>users/toggle-status/<?php echo $user['id']; ?>"
                                                class="text-yellow-600 hover:text-yellow-900" title="Deactivate"
                                                onclick="return confirm('Deactivate this user?')">
                                                <i class="fas fa-user-slash"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo BASE_URL; ?>users/toggle-status/<?php echo $user['id']; ?>"
                                                class="text-green-600 hover:text-green-900" title="Activate"
                                                onclick="return confirm('Activate this user?')">
                                                <i class="fas fa-user-check"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?php echo BASE_URL; ?>users/delete/<?php echo $user['id']; ?>"
                                            class="text-red-600 hover:text-red-900" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination (optional) -->
        <div class="px-6 py-4 border-t flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium"><?php echo count($users); ?></span> of <span class="font-medium"><?php echo count($users); ?></span> results
            </div>
            <div class="flex space-x-2">
                <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50" disabled>
                    Previous
                </button>
                <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../views/layouts/main.php';
?>