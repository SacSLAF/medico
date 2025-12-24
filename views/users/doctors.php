<?php
$title = 'Manage Doctors';
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Manage Doctors</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    
    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manage Doctors</h1>
            <p class="text-gray-600">View and manage all medical doctors</p>
        </div>
        <a href="<?php echo BASE_URL; ?>users/add" 
           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
            <i class="fas fa-user-plus mr-2"></i> Add New Doctor
        </a>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-user-md text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Doctors</p>
                    <p class="text-2xl font-bold"><?php echo count($doctors); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Active Doctors</p>
                    <p class="text-2xl font-bold">
                        <?php 
                        $active = array_filter($doctors, function($doctor) {
                            return $doctor['is_active'];
                        });
                        echo count($active);
                        ?>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Today's Appointments</p>
                    <p class="text-2xl font-bold">0</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Doctors Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">All Doctors</h2>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search doctors..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Specializations</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Pediatrician">Pediatrician</option>
                    <option value="Neurologist">Neurologist</option>
                    <option value="Orthopedic">Orthopedic</option>
                    <option value="Dermatologist">Dermatologist</option>
                </select>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Doctor
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Specialization & License
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (count($doctors) > 0): ?>
                        <?php foreach ($doctors as $doctor): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <?php if ($doctor['profile_image']): ?>
                                            <img class="h-10 w-10 rounded-full" src="<?php echo htmlspecialchars($doctor['profile_image']); ?>" alt="">
                                        <?php else: ?>
                                            <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user-md text-blue-600"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Dr. <?php echo htmlspecialchars($doctor['first_name'] . ' ' . $doctor['last_name']); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            @<?php echo htmlspecialchars($doctor['username']); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($doctor['specialization'] ?: 'General Physician'); ?>
                                </div>
                                <?php if ($doctor['license_number']): ?>
                                    <div class="text-sm text-gray-500">
                                        License: <?php echo htmlspecialchars($doctor['license_number']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($doctor['email']); ?></div>
                                <?php if ($doctor['phone']): ?>
                                    <div class="text-sm text-gray-500"><?php echo htmlspecialchars($doctor['phone']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($doctor['is_active']): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-circle mr-1" style="font-size: 6px;"></i> Active
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-circle mr-1" style="font-size: 6px;"></i> Inactive
                                    </span>
                                <?php endif; ?>
                                <div class="text-xs text-gray-500 mt-1">
                                    <?php echo date('M d, Y', strtotime($doctor['created_at'])); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="<?php echo BASE_URL; ?>users/view/<?php echo $doctor['id']; ?>" 
                                       class="text-blue-600 hover:text-blue-900" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>users/edit/<?php echo $doctor['id']; ?>" 
                                       class="text-green-600 hover:text-green-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($doctor['id'] != $_SESSION['user_id']): ?>
                                        <?php if ($doctor['is_active']): ?>
                                            <a href="<?php echo BASE_URL; ?>users/toggleStatus/<?php echo $doctor['id']; ?>" 
                                               class="text-yellow-600 hover:text-yellow-900" title="Deactivate"
                                               onclick="return confirm('Deactivate this doctor?')">
                                                <i class="fas fa-user-slash"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo BASE_URL; ?>users/toggleStatus/<?php echo $doctor['id']; ?>" 
                                               class="text-green-600 hover:text-green-900" title="Activate"
                                               onclick="return confirm('Activate this doctor?')">
                                                <i class="fas fa-user-check"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-user-md text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No doctors found</h3>
                                <p class="text-gray-500 mb-4">Get started by adding your first doctor to the system.</p>
                                <a href="<?php echo BASE_URL; ?>users/add" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    <i class="fas fa-user-plus mr-2"></i> Add First Doctor
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium"><?php echo count($doctors); ?></span> of <span class="font-medium"><?php echo count($doctors); ?></span> results
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
    
    <!-- Quick Stats -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Specializations</h3>
            <div class="space-y-2">
                <?php
                $specializations = [];
                foreach ($doctors as $doctor) {
                    if ($doctor['specialization']) {
                        $specializations[$doctor['specialization']] = ($specializations[$doctor['specialization']] ?? 0) + 1;
                    }
                }
                ?>
                <?php if (count($specializations) > 0): ?>
                    <?php foreach ($specializations as $spec => $count): ?>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600"><?php echo htmlspecialchars($spec); ?></span>
                        <span class="text-sm font-medium text-gray-900"><?php echo $count; ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-sm text-gray-500">No specializations recorded</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Recent Additions</h3>
            <div class="space-y-3">
                <?php 
                $recentDoctors = array_slice($doctors, 0, 3);
                foreach ($recentDoctors as $doctor): 
                ?>
                <div class="flex items-center">
                    <div class="h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                        <span class="text-xs font-medium text-gray-600">
                            <?php echo strtoupper(substr($doctor['first_name'], 0, 1)); ?>
                        </span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">
                            Dr. <?php echo htmlspecialchars($doctor['first_name']); ?>
                        </div>
                        <div class="text-xs text-gray-500">
                            <?php echo date('M d', strtotime($doctor['created_at'])); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Availability</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">On Duty Today</span>
                    <span class="text-sm font-medium text-green-600"><?php echo count(array_filter($doctors, fn($d) => $d['is_active'])); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">On Leave</span>
                    <span class="text-sm font-medium text-yellow-600">0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Available for Consultation</span>
                    <span class="text-sm font-medium text-blue-600"><?php echo count($doctors); ?></span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Quick Actions</h3>
            <div class="space-y-3">
                <a href="<?php echo BASE_URL; ?>users/add?role=2" 
                   class="block w-full text-center px-3 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 text-sm">
                    <i class="fas fa-plus mr-1"></i> Add Doctor
                </a>
                <a href="#" 
                   class="block w-full text-center px-3 py-2 bg-green-50 text-green-700 rounded-md hover:bg-green-100 text-sm">
                    <i class="fas fa-calendar-plus mr-1"></i> Schedule
                </a>
                <a href="#" 
                   class="block w-full text-center px-3 py-2 bg-purple-50 text-purple-700 rounded-md hover:bg-purple-100 text-sm">
                    <i class="fas fa-chart-bar mr-1"></i> Reports
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../views/layouts/main.php';
?>