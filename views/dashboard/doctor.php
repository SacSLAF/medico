<?php
$title = 'Doctor Dashboard';
$showNavbar = true;
// ob_start(); // Remove this if you're using the extract() method
?>

<div class="container mx-auto px-4 py-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, Dr. <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>!</h1>
        <p class="text-gray-600">Medical Professional Dashboard</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-calendar-day text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Today's Appointments</p>
                    <p class="text-2xl font-bold"><?php echo $stats['today_appointments'] ?? 0; ?></p>
                </div>
            </div>
            <a href="#" class="mt-4 block text-blue-600 hover:text-blue-800 text-sm font-medium">
                View Schedule →
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-user-injured text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Patients</p>
                    <p class="text-2xl font-bold"><?php echo $stats['total_patients'] ?? 0; ?></p>
                </div>
            </div>
            <a href="#" class="mt-4 block text-green-600 hover:text-green-800 text-sm font-medium">
                Patient List →
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
                Write Prescription →
            </a>
        </div>
    </div>
    
    <!-- Today's Schedule -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Today's Schedule</h2>
            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View Full Schedule
            </a>
        </div>
        <div class="p-6">
            <?php if (!empty($todaySchedule)): ?>
                <div class="space-y-4">
                    <?php foreach ($todaySchedule as $appointment): ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div>
                            <h3 class="font-medium text-gray-800"><?php echo htmlspecialchars($appointment['patient_name']); ?></h3>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-clock mr-1"></i>
                                <?php echo htmlspecialchars($appointment['appointment_time']); ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-stethoscope mr-1"></i>
                                <?php echo htmlspecialchars($appointment['reason'] ?? 'Regular Checkup'); ?>
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <span class="px-3 py-1 text-xs rounded-full 
                                <?php echo $appointment['status'] == 'Scheduled' ? 'bg-blue-100 text-blue-800' : 
                                          ($appointment['status'] == 'Confirmed' ? 'bg-green-100 text-green-800' : 
                                          ($appointment['status'] == 'In Progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                <?php echo htmlspecialchars($appointment['status']); ?>
                            </span>
                            <a href="#" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-calendar-times text-4xl"></i>
                    </div>
                    <p class="text-gray-500">No appointments scheduled for today</p>
                    <a href="#" class="mt-2 inline-block text-blue-600 hover:text-blue-800">
                        Schedule an appointment
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="#" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition text-center">
            <div class="text-blue-600 mb-3">
                <i class="fas fa-calendar-plus text-3xl"></i>
            </div>
            <h3 class="font-medium text-gray-800">New Appointment</h3>
            <p class="text-sm text-gray-600 mt-1">Schedule patient visit</p>
        </a>
        
        <a href="#" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition text-center">
            <div class="text-green-600 mb-3">
                <i class="fas fa-file-medical text-3xl"></i>
            </div>
            <h3 class="font-medium text-gray-800">Patient History</h3>
            <p class="text-sm text-gray-600 mt-1">View medical records</p>
        </a>
        
        <a href="#" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition text-center">
            <div class="text-purple-600 mb-3">
                <i class="fas fa-prescription-bottle-alt text-3xl"></i>
            </div>
            <h3 class="font-medium text-gray-800">Write Prescription</h3>
            <p class="text-sm text-gray-600 mt-1">Create new prescription</p>
        </a>
        
        <a href="#" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition text-center">
            <div class="text-red-600 mb-3">
                <i class="fas fa-chart-line text-3xl"></i>
            </div>
            <h3 class="font-medium text-gray-800">Reports</h3>
            <p class="text-sm text-gray-600 mt-1">View medical reports</p>
        </a>
    </div>
</div>

<?php
// Remove these lines if using extract() method:
// $content = ob_get_clean();
// include '../views/layouts/main.php';
?>