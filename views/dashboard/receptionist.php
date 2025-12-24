<?php
$title = 'Receptionist Dashboard';
$showNavbar = true;
?>

<div class="container mx-auto px-4 py-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>!</h1>
        <p class="text-gray-600">Reception & Front Desk Dashboard</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">New Patients Today</p>
                    <p class="text-2xl font-bold"><?php echo $stats['new_patients_today'] ?? 0; ?></p>
                </div>
            </div>
            <a href="#" class="mt-4 block text-green-600 hover:text-green-800 text-sm font-medium">
                Register New Patient →
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Today's Appointments</p>
                    <p class="text-2xl font-bold"><?php echo $stats['today_appointments'] ?? 0; ?></p>
                </div>
            </div>
            <a href="#" class="mt-4 block text-blue-600 hover:text-blue-800 text-sm font-medium">
                Manage Appointments →
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-file-invoice-dollar text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pending Bills</p>
                    <p class="text-2xl font-bold"><?php echo $stats['pending_bills'] ?? 0; ?></p>
                </div>
            </div>
            <a href="#" class="mt-4 block text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                Process Payments →
            </a>
        </div>
    </div>
    
    <!-- Recent Patients & Quick Actions Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Patients -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-bold text-gray-800">Recent Patients</h2>
            </div>
            <div class="p-6">
                <?php if (!empty($recentPatients)): ?>
                    <div class="space-y-4">
                        <?php foreach ($recentPatients as $patient): ?>
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800"><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></h3>
                                    <p class="text-sm text-gray-600">
                                        ID: <?php echo htmlspecialchars($patient['patient_id']); ?> | 
                                        <i class="fas fa-phone-alt mr-1"></i><?php echo htmlspecialchars($patient['phone']); ?>
                                    </p>
                                </div>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-users text-4xl"></i>
                        </div>
                        <p class="text-gray-500">No recent patients</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="bg-blue-50 hover:bg-blue-100 text-blue-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-user-plus text-2xl mb-2"></i>
                    <p class="font-medium">Register Patient</p>
                </a>
                
                <a href="#" class="bg-green-50 hover:bg-green-100 text-green-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-calendar-plus text-2xl mb-2"></i>
                    <p class="font-medium">Book Appointment</p>
                </a>
                
                <a href="#" class="bg-purple-50 hover:bg-purple-100 text-purple-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-file-invoice text-2xl mb-2"></i>
                    <p class="font-medium">Generate Bill</p>
                </a>
                
                <a href="#" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-search text-2xl mb-2"></i>
                    <p class="font-medium">Find Patient</p>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Today's Appointments -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Today's Appointments</h2>
            <div class="flex space-x-2">
                <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                    <i class="fas fa-plus mr-1"></i> New Appointment
                </a>
                <a href="#" class="px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50 text-sm">
                    View All
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Time</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Patient</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Doctor</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Sample appointment rows -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <span class="font-medium">09:00 AM</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium">John Smith</div>
                                <div class="text-sm text-gray-500">ID: PAT-001</div>
                            </td>
                            <td class="px-4 py-3">Dr. Sarah Johnson</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Confirmed
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <button class="text-blue-600 hover:text-blue-800 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- More rows can be added dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>