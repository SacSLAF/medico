<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-8 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold">Appointment Status</h1>
                            <p class="text-blue-100 mt-2">View your appointment details</p>
                        </div>
                        <a href="<?php echo BASE_URL; ?>patient/checkAppointmentForm" 
                           class="text-sm bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-search mr-1"></i> Check Another
                        </a>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8">
                    <?php if ($appointment): ?>
                        <!-- Appointment Found -->
                        <div class="space-y-8">
                            <!-- Status Badge -->
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">Appointment Details</h2>
                                    <p class="text-gray-600 text-sm">Appointment #<?php echo htmlspecialchars($appointment['appointment_number']); ?></p>
                                </div>
                                <?php
                                $statusColors = [
                                    'Scheduled' => 'bg-blue-100 text-blue-800',
                                    'Confirmed' => 'bg-green-100 text-green-800',
                                    'In Progress' => 'bg-yellow-100 text-yellow-800',
                                    'Completed' => 'bg-purple-100 text-purple-800',
                                    'Cancelled' => 'bg-red-100 text-red-800',
                                    'No Show' => 'bg-gray-100 text-gray-800'
                                ];
                                $statusClass = $statusColors[$appointment['status']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-4 py-2 rounded-full text-sm font-medium <?php echo $statusClass; ?>">
                                    <?php echo htmlspecialchars($appointment['status']); ?>
                                </span>
                            </div>

                            <!-- Appointment Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Patient Information -->
                                <div class="space-y-6">
                                    <div class="bg-gray-50 rounded-xl p-6">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-user mr-2 text-blue-600"></i>
                                            Patient Information
                                        </h3>
                                        <div class="space-y-3">
                                            <div>
                                                <span class="text-sm text-gray-500">Name</span>
                                                <p class="font-medium text-gray-800"><?php echo htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']); ?></p>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Phone</span>
                                                <p class="font-medium text-gray-800"><?php echo htmlspecialchars($appointment['phone']); ?></p>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Appointment Number</span>
                                                <p class="font-mono font-bold text-lg text-gray-800"><?php echo htmlspecialchars($appointment['appointment_number']); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Appointment Details -->
                                    <div class="bg-gray-50 rounded-xl p-6">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-calendar-alt mr-2 text-green-600"></i>
                                            Appointment Details
                                        </h3>
                                        <div class="space-y-3">
                                            <div>
                                                <span class="text-sm text-gray-500">Date</span>
                                                <p class="font-medium text-gray-800">
                                                    <i class="far fa-calendar mr-2 text-gray-400"></i>
                                                    <?php echo date('F j, Y', strtotime($appointment['appointment_date'])); ?>
                                                    (<?php echo date('l', strtotime($appointment['appointment_date'])); ?>)
                                                </p>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Time</span>
                                                <p class="font-medium text-gray-800">
                                                    <i class="far fa-clock mr-2 text-gray-400"></i>
                                                    <?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?>
                                                </p>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Duration</span>
                                                <p class="font-medium text-gray-800">30 minutes</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Doctor & Additional Info -->
                                <div class="space-y-6">
                                    <!-- Doctor Information -->
                                    <div class="bg-gray-50 rounded-xl p-6">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-user-md mr-2 text-purple-600"></i>
                                            Doctor Information
                                        </h3>
                                        <div class="space-y-3">
                                            <div>
                                                <span class="text-sm text-gray-500">Doctor</span>
                                                <p class="font-medium text-gray-800">Dr. <?php echo htmlspecialchars($appointment['doctor_name']); ?></p>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-500">Consultation Type</span>
                                                <p class="font-medium text-gray-800">General Consultation</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reason for Visit -->
                                    <div class="bg-gray-50 rounded-xl p-6">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-file-medical-alt mr-2 text-red-600"></i>
                                            Reason for Visit
                                        </h3>
                                        <div class="space-y-3">
                                            <?php if ($appointment['reason']): ?>
                                            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($appointment['reason'])); ?></p>
                                            <?php else: ?>
                                            <p class="text-gray-500 italic">No reason provided</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Important Notes -->
                                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2 text-blue-600"></i>
                                            Important Notes
                                        </h3>
                                        <ul class="space-y-2 text-sm text-gray-700">
                                            <li class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2 text-xs"></i>
                                                Arrive 15 minutes before your appointment
                                            </li>
                                            <li class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2 text-xs"></i>
                                                Bring your ID and medical records if any
                                            </li>
                                            <li class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2 text-xs"></i>
                                                Cancel at least 24 hours in advance if needed
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="pt-8 border-t border-gray-200">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <a href="<?php echo BASE_URL; ?>patient/checkAppointmentForm" 
                                       class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium text-center">
                                        <i class="fas fa-search mr-2"></i>
                                        Check Another
                                    </a>
                                    
                                    <button onclick="printAppointment()"
                                            class="flex-1 border border-blue-600 text-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 font-medium">
                                        <i class="fas fa-print mr-2"></i>
                                        Print Details
                                    </button>
                                    
                                    <a href="<?php echo BASE_URL; ?>patient/bookAppointmentForm" 
                                       class="flex-1 border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium text-center">
                                        <i class="fas fa-calendar-plus mr-2"></i>
                                        Book New
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- No Appointment Found -->
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-3">Appointment Not Found</h2>
                            <p class="text-gray-600 mb-8">We couldn't find an appointment with the provided details. Please check your information and try again.</p>
                            
                            <div class="space-y-4 max-w-md mx-auto">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <div class="flex items-start">
                                        <i class="fas fa-lightbulb text-yellow-500 mt-0.5 mr-3"></i>
                                        <div>
                                            <h4 class="text-sm font-medium text-yellow-800">Possible Issues</h4>
                                            <ul class="mt-2 text-sm text-yellow-700 space-y-1">
                                                <li>• Incorrect appointment number</li>
                                                <li>• Phone number doesn't match</li>
                                                <li>• Appointment might have been cancelled</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <a href="<?php echo BASE_URL; ?>patient/check-appointment" 
                                       class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium text-center">
                                        <i class="fas fa-redo mr-2"></i>
                                        Try Again
                                    </a>
                                    
                                    <a href="<?php echo BASE_URL; ?>patient/book-appointment" 
                                       class="flex-1 border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium text-center">
                                        <i class="fas fa-calendar-plus mr-2"></i>
                                        Book Appointment
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Contact Section -->
            <div class="mt-8 text-center text-gray-600">
                <p>Need assistance? Call us at <span class="font-medium text-blue-600">+94 11 234 5678</span> or email <span class="font-medium text-blue-600">info@medico.lk</span></p>
            </div>
        </div>
    </div>
</div>

<script>
    function printAppointment() {
        window.print();
    }
</script>