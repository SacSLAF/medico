<?php
$title = 'View Reports';
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Reports</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Reports & Analytics</h1>
                <p class="text-gray-600">Comprehensive insights and statistics</p>
            </div>
            <div class="flex space-x-3">
                <a href="<?php echo BASE_URL; ?>reports/export" 
                   class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 flex items-center">
                    <i class="fas fa-file-export mr-2"></i> Export PDF
                </a>
            </div>
        </div>
        
        <!-- Date Range Filter -->
        <div class="mt-6 bg-white rounded-lg shadow p-4">
            <form method="GET" action="<?php echo BASE_URL; ?>reports" class="flex flex-col md:flex-row md:items-center md:space-x-4">
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <button type="submit" 
                            class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i> Apply Filter
                    </button>
                </div>
            </form>
            <div class="mt-3 flex flex-wrap gap-2">
                <a href="<?php echo BASE_URL; ?>reports?start_date=<?php echo date('Y-m-d', strtotime('-7 days')); ?>&end_date=<?php echo date('Y-m-d'); ?>"
                   class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">
                    Last 7 Days
                </a>
                <a href="<?php echo BASE_URL; ?>reports?start_date=<?php echo date('Y-m-01'); ?>&end_date=<?php echo date('Y-m-d'); ?>"
                   class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">
                    This Month
                </a>
                <a href="<?php echo BASE_URL; ?>reports?start_date=<?php echo date('Y-m-d', strtotime('-30 days')); ?>&end_date=<?php echo date('Y-m-d'); ?>"
                   class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">
                    Last 30 Days
                </a>
                <a href="<?php echo BASE_URL; ?>reports?start_date=<?php echo date('Y-01-01'); ?>&end_date=<?php echo date('Y-m-d'); ?>"
                   class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200">
                    This Year
                </a>
            </div>
        </div>
    </div>
    
    <!-- Report Navigation -->
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <h2 class="text-xl font-bold text-gray-800">Report Categories</h2>
            </div>
            <div class="p-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="<?php echo BASE_URL; ?>reports" 
                   class="bg-blue-50 hover:bg-blue-100 text-blue-700 p-4 rounded-lg text-center transition <?php echo basename($_SERVER['REQUEST_URI']) == 'reports' ? 'ring-2 ring-blue-500' : ''; ?>">
                    <i class="fas fa-chart-line text-2xl mb-2"></i>
                    <p class="font-medium">Overview</p>
                </a>
                <a href="<?php echo BASE_URL; ?>reports/patients" 
                   class="bg-green-50 hover:bg-green-100 text-green-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-user-injured text-2xl mb-2"></i>
                    <p class="font-medium">Patients</p>
                </a>
                <a href="<?php echo BASE_URL; ?>reports/appointments" 
                   class="bg-purple-50 hover:bg-purple-100 text-purple-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-calendar-check text-2xl mb-2"></i>
                    <p class="font-medium">Appointments</p>
                </a>
                <a href="<?php echo BASE_URL; ?>reports/financial" 
                   class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-money-bill-wave text-2xl mb-2"></i>
                    <p class="font-medium">Financial</p>
                </a>
                <a href="<?php echo BASE_URL; ?>reports/pharmacy" 
                   class="bg-red-50 hover:bg-red-100 text-red-700 p-4 rounded-lg text-center transition">
                    <i class="fas fa-prescription-bottle-alt text-2xl mb-2"></i>
                    <p class="font-medium">Pharmacy</p>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Key Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Total Patients</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo $stats['total_patients']; ?></p>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-user-injured text-xl"></i>
                </div>
            </div>
            <div class="text-sm text-gray-600">
                <span class="text-green-600 font-medium">+<?php echo $stats['new_patients']; ?> new</span> this period
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Total Appointments</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo $stats['total_appointments']; ?></p>
                </div>
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
            </div>
            <div class="text-sm text-gray-600">
                <span class="text-green-600 font-medium"><?php echo $stats['completed_appointments']; ?> completed</span>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-800">$<?php echo number_format($stats['total_revenue'], 2); ?></p>
                </div>
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
            </div>
            <div class="text-sm text-gray-600">
                Average: $<?php echo $stats['total_appointments'] > 0 ? number_format($stats['total_revenue'] / $stats['total_appointments'], 2) : '0.00'; ?> per appointment
            </div>
        </div>
    </div>
    
    <!-- Charts & Detailed Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Top Doctors -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-bold text-gray-800">Top Performing Doctors</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php if (count($topDoctors) > 0): ?>
                        <?php foreach ($topDoctors as $index => $doctor): ?>
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
                            <div class="flex items-center">
                                <div class="text-gray-400 font-medium mr-4">#<?php echo $index + 1; ?></div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Dr. <?php echo htmlspecialchars($doctor['doctor_name']); ?></h3>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($doctor['specialization'] ?: 'General Physician'); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-medium text-gray-800"><?php echo $doctor['appointment_count']; ?> appointments</div>
                                <div class="text-sm text-gray-600"><?php echo $doctor['prescription_count']; ?> prescriptions</div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500 text-center py-4">No appointment data available</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Daily Trends -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-bold text-gray-800">Daily Activity</h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Date</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Patients</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Appointments</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (count($dailyStats) > 0): ?>
                                <?php foreach (array_slice($dailyStats, -7) as $day): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm"><?php echo date('M d', strtotime($day['date'])); ?></td>
                                    <td class="px-4 py-3 text-sm"><?php echo $day['patients']; ?></td>
                                    <td class="px-4 py-3 text-sm"><?php echo $day['appointments']; ?></td>
                                    <td class="px-4 py-3 text-sm">
                                        <?php 
                                        $dayRevenue = 0;
                                        foreach ($revenueData as $rev) {
                                            if ($rev['date'] == $day['date']) {
                                                $dayRevenue = $rev['revenue'];
                                                break;
                                            }
                                        }
                                        echo '$' . number_format($dayRevenue, 2);
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Insights -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b">
            <h2 class="text-xl font-bold text-gray-800">Quick Insights</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600 mb-2"><?php echo $stats['total_prescriptions']; ?></div>
                <p class="text-sm text-gray-600">Total Prescriptions</p>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600 mb-2">
                    <?php echo $stats['total_appointments'] > 0 ? round(($stats['completed_appointments'] / $stats['total_appointments']) * 100) : 0; ?>%
                </div>
                <p class="text-sm text-gray-600">Completion Rate</p>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600 mb-2">
                    <?php echo $stats['total_appointments'] > 0 ? round($stats['total_appointments'] / 30) : 0; ?>
                </div>
                <p class="text-sm text-gray-600">Avg Daily Appointments</p>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-600 mb-2">
                    $<?php echo $stats['total_revenue'] > 0 ? number_format($stats['total_revenue'] / 30, 2) : '0.00'; ?>
                </div>
                <p class="text-sm text-gray-600">Avg Daily Revenue</p>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="<?php echo BASE_URL; ?>reports/patients" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-user-injured text-xl"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">Patient Reports</h3>
                    <p class="text-sm text-gray-600">Demographics, growth, and trends</p>
                </div>
            </div>
        </a>
        
        <a href="<?php echo BASE_URL; ?>reports/financial" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">Financial Reports</h3>
                    <p class="text-sm text-gray-600">Revenue, expenses, and profitability</p>
                </div>
            </div>
        </a>
        
        <a href="<?php echo BASE_URL; ?>reports/pharmacy" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                    <i class="fas fa-prescription-bottle-alt text-xl"></i>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">Pharmacy Reports</h3>
                    <p class="text-sm text-gray-600">Inventory, sales, and expirations</p>
                </div>
            </div>
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../views/layouts/main.php';
?>