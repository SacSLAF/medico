<?php
$title = 'Doctor Schedule';
$showNavbar = true;
// ob_start();
?>

<div class="container mx-auto px-4 py-8 pt-16">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Schedule Management</h1>
        <p class="text-gray-600">Manage your appointments and availability</p>
    </div>
    
    <!-- Schedule Controls -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex justify-between items-center">
            <div class="flex space-x-4">
                <button id="today-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Today
                </button>
                <button id="week-btn" class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200">
                    This Week
                </button>
                <button id="month-btn" class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200">
                    This Month
                </button>
            </div>
            <div class="flex space-x-4">
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i> New Appointment
                </button>
                <button class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i> Set Availability
                </button>
            </div>
        </div>
        
        <!-- Date Navigation -->
        <div class="mt-6 flex items-center justify-center">
            <button class="p-2 rounded-full hover:bg-gray-100">
                <i class="fas fa-chevron-left"></i>
            </button>
            <h2 class="mx-4 text-xl font-bold text-gray-800">
                <?php echo date('F d, Y'); ?> - Today's Appointments
            </h2>
            <button class="p-2 rounded-full hover:bg-gray-100">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
    
    <!-- Schedule Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-xl font-bold text-gray-800">Appointments</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Time
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Patient
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Reason
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
                    <?php if (!empty($schedule)): ?>
                        <?php foreach ($schedule as $appointment): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">
                                    <?php echo htmlspecialchars($appointment['appointment_time']); ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?php echo htmlspecialchars($appointment['appointment_date']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            <?php echo htmlspecialchars($appointment['patient_first_name'] . ' ' . $appointment['patient_last_name']); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            ID: <?php echo htmlspecialchars($appointment['patient_id']); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?php echo htmlspecialchars($appointment['phone']); ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?php echo htmlspecialchars($appointment['email']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <?php echo htmlspecialchars($appointment['reason'] ?? 'Regular Checkup'); ?>
                                </div>
                                <?php if (!empty($appointment['notes'])): ?>
                                <div class="text-xs text-gray-500 mt-1">
                                    <?php echo htmlspecialchars($appointment['notes']); ?>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs rounded-full 
                                    <?php echo $appointment['status'] == 'Scheduled' ? 'bg-blue-100 text-blue-800' : 
                                              ($appointment['status'] == 'Confirmed' ? 'bg-green-100 text-green-800' : 
                                              ($appointment['status'] == 'In Progress' ? 'bg-yellow-100 text-yellow-800' : 
                                              ($appointment['status'] == 'Completed' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800'))); ?>">
                                    <?php echo htmlspecialchars($appointment['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <div class="text-gray-400 mb-4">
                                    <i class="fas fa-calendar-times text-4xl"></i>
                                </div>
                                <p>No appointments found for the selected period</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination (optional) -->
        <div class="px-6 py-4 border-t">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium"><?php echo count($schedule); ?></span> appointments
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
    
    <!-- Calendar View (optional) -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Calendar View</h2>
        <div class="grid grid-cols-7 gap-2">
            <!-- Calendar header -->
            <?php 
            $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            foreach ($days as $day): 
            ?>
            <div class="text-center font-medium text-gray-500 py-2">
                <?php echo $day; ?>
            </div>
            <?php endforeach; ?>
            
            <!-- Calendar days -->
            <?php for ($i = 1; $i <= 35; $i++): ?>
            <div class="border rounded-lg p-2 h-24 hover:bg-gray-50 cursor-pointer">
                <div class="text-right text-sm text-gray-500"><?php echo $i; ?></div>
                <?php if ($i == date('j')): ?>
                <div class="mt-1 text-xs bg-blue-100 text-blue-800 rounded px-2 py-1">
                    3 Appointments
                </div>
                <?php endif; ?>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const todayBtn = document.getElementById('today-btn');
    const weekBtn = document.getElementById('week-btn');
    const monthBtn = document.getElementById('month-btn');
    
    const buttons = [todayBtn, weekBtn, monthBtn];
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-800');
            });
            
            // Add active class to clicked button
            this.classList.remove('bg-gray-100', 'text-gray-800');
            this.classList.add('bg-blue-600', 'text-white');
            
            // Here you would typically make an AJAX request to load the appropriate data
            console.log('Loading ' + this.textContent + ' schedule');
        });
    });
});
</script>
