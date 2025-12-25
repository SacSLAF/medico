<?php
$title = 'Patient List';
$showNavbar = true;
// ob_start();
?>

<div class="container mx-auto px-4 py-8 pt-16">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Patient Management</h1>
                <p class="text-gray-600">Manage your patients and their medical records</p>
            </div>
            <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fas fa-user-plus mr-2"></i> Add New Patient
            </button>
        </div>
    </div>
    
    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Patients</label>
                <div class="relative">
                    <input type="text" 
                           placeholder="Search by name, ID, or phone..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="new">New</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Visit</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Any Time</option>
                    <option value="week">Last Week</option>
                    <option value="month">Last Month</option>
                    <option value="3months">Last 3 Months</option>
                </select>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-2 mt-6">
            <button class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                <i class="fas fa-print mr-2"></i> Print List
            </button>
            <button class="px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200">
                <i class="fas fa-file-export mr-2"></i> Export
            </button>
            <button class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200">
                <i class="fas fa-chart-bar mr-2"></i> Reports
            </button>
        </div>
    </div>
    
    <!-- Patients Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Patient List</h2>
            <div class="text-sm text-gray-600">
                Total: <span class="font-bold"><?php echo count($patients); ?></span> patients
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Patient
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact Info
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Age/Gender
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Last Visit
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Visits
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
                    <?php if (!empty($patients)): ?>
                        <?php foreach ($patients as $patient): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            ID: <?php echo htmlspecialchars($patient['id']); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <i class="fas fa-phone-alt mr-2 text-gray-400"></i>
                                    <?php echo htmlspecialchars($patient['phone'] ?? 'N/A'); ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                    <?php echo htmlspecialchars($patient['email'] ?? 'N/A'); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?php 
                                    if (isset($patient['date_of_birth'])) {
                                        $birthDate = new DateTime($patient['date_of_birth']);
                                        $today = new DateTime('today');
                                        $age = $birthDate->diff($today)->y;
                                        echo $age . ' years';
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?php echo htmlspecialchars($patient['gender'] ?? 'N/A'); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?php 
                                    if (isset($patient['last_visit']) && $patient['last_visit']) {
                                        echo date('M d, Y', strtotime($patient['last_visit']));
                                    } else {
                                        echo 'No visits yet';
                                    }
                                    ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    <?php echo htmlspecialchars($patient['appointment_count'] ?? 0); ?> visits
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs rounded-full 
                                    <?php echo ($patient['appointment_count'] ?? 0) > 3 ? 'bg-green-100 text-green-800' : 
                                              (($patient['appointment_count'] ?? 0) > 0 ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                    <?php echo ($patient['appointment_count'] ?? 0) > 3 ? 'Regular' : 
                                           (($patient['appointment_count'] ?? 0) > 0 ? 'Occasional' : 'New'); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-900" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="text-green-600 hover:text-green-900" title="Medical History">
                                        <i class="fas fa-file-medical"></i>
                                    </a>
                                    <a href="#" class="text-purple-600 hover:text-purple-900" title="Schedule Appointment">
                                        <i class="fas fa-calendar-plus"></i>
                                    </a>
                                    <a href="#" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-users-slash text-4xl"></i>
                                </div>
                                <p>No patients found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium"><?php echo count($patients); ?></span> patients
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
                        Previous
                    </button>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded">
                        1
                    </button>
                    <button class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
                        2
                    </button>
                    <button class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
        <div class="bg-blue-50 rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-user-friends text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-blue-700">Total Patients</p>
                    <p class="text-2xl font-bold text-blue-800"><?php echo count($patients); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-green-700">This Month</p>
                    <p class="text-2xl font-bold text-green-800">12</p>
                </div>
            </div>
        </div>
        
        <div class="bg-yellow-50 rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-yellow-700">New This Month</p>
                    <p class="text-2xl font-bold text-yellow-800">3</p>
                </div>
            </div>
        </div>
        
        <div class="bg-purple-50 rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-purple-700">Avg Visits/Patient</p>
                    <p class="text-2xl font-bold text-purple-800">2.4</p>
                </div>
            </div>
        </div>
    </div>
</div>
