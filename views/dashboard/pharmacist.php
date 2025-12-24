<?php
$title = 'Pharmacist Dashboard';
$showNavbar = true;
?>

<div class="container mx-auto px-4 py-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>!</h1>
        <p class="text-gray-600">Pharmacy & Inventory Management</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Low Stock Medicines</p>
                    <p class="text-2xl font-bold"><?php echo $stats['low_stock'] ?? 0; ?></p>
                </div>
            </div>
            <a href="#" class="mt-4 block text-red-600 hover:text-red-800 text-sm font-medium">
                View Inventory →
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-prescription text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pending Prescriptions</p>
                    <p class="text-2xl font-bold"><?php echo $stats['pending_prescriptions'] ?? 0; ?></p>
                </div>
            </div>
            <a href="#" class="mt-4 block text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                Process Prescriptions →
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Today's Sales</p>
                    <p class="text-2xl font-bold">$<?php echo $stats['today_sales'] ?? '0.00'; ?></p>
                </div>
            </div>
            <a href="#" class="mt-4 block text-green-600 hover:text-green-800 text-sm font-medium">
                View Sales Report →
            </a>
        </div>
    </div>
    
    <!-- Expiring Medicines & Quick Actions Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Expiring Medicines -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-bold text-gray-800">Expiring Medicines (Next 30 Days)</h2>
            </div>
            <div class="p-6">
                <?php if (!empty($expiringMedicines)): ?>
                    <div class="space-y-4">
                        <?php foreach ($expiringMedicines as $medicine): ?>
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
                            <div>
                                <h3 class="font-medium text-gray-800"><?php echo htmlspecialchars($medicine['name']); ?></h3>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Code:</span> <?php echo htmlspecialchars($medicine['medicine_code']); ?> | 
                                    <span class="font-medium">Qty:</span> <?php echo htmlspecialchars($medicine['stock_quantity']); ?>
                                </p>
                                <p class="text-sm <?php echo strtotime($medicine['expiry_date']) < strtotime('+7 days') ? 'text-red-600' : 'text-yellow-600'; ?>">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Expires: <?php echo date('M d, Y', strtotime($medicine['expiry_date'])); ?>
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs rounded-full 
                                <?php echo strtotime($medicine['expiry_date']) < strtotime('+7 days') ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                <?php echo strtotime($medicine['expiry_date']) < strtotime('+7 days') ? 'Urgent' : 'Warning'; ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-check-circle text-4xl"></i>
                        </div>
                        <p class="text-gray-500">No medicines expiring soon</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="bg-blue-50 hover:bg-blue-100 text-blue-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-prescription text-2xl mb-2"></i>
                    <p class="font-medium">Dispense Prescription</p>
                </a>
                
                <a href="#" class="bg-green-50 hover:bg-green-100 text-green-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-boxes text-2xl mb-2"></i>
                    <p class="font-medium">Add Stock</p>
                </a>
                
                <a href="#" class="bg-purple-50 hover:bg-purple-100 text-purple-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-search text-2xl mb-2"></i>
                    <p class="font-medium">Search Medicine</p>
                </a>
                
                <a href="#" class="bg-red-50 hover:bg-red-100 text-red-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-chart-bar text-2xl mb-2"></i>
                    <p class="font-medium">Sales Report</p>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Pending Prescriptions -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Pending Prescriptions</h2>
            <div class="flex space-x-2">
                <a href="#" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                    <i class="fas fa-check mr-1"></i> Mark as Fulfilled
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
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Prescription #</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Patient</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Doctor</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Date</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Items</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Sample prescription rows -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">RX-001</td>
                            <td class="px-4 py-3">John Smith</td>
                            <td class="px-4 py-3">Dr. Sarah Johnson</td>
                            <td class="px-4 py-3"><?php echo date('M d, Y'); ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">3 items</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="#" class="text-blue-600 hover:text-blue-800 mr-3" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="text-green-600 hover:text-green-800" title="Dispense">
                                    <i class="fas fa-check"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- More rows can be added dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>