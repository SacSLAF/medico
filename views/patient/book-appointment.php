<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps -->
        <div class="py-8">
            <div class="max-w-3xl mx-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-green-600">Registration</span>
                    </div>
                    <div class="h-1 flex-1 mx-4 bg-green-200"></div>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar text-white text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-green-600">Appointment</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-4xl mx-auto pb-12">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-600 to-green-800 px-8 py-6 text-white">
                    <h1 class="text-3xl font-bold">Book Appointment</h1>
                    <p class="text-green-100 mt-2">Schedule your visit with our expert doctors</p>
                </div>

                <!-- Form -->
                <form id="appointmentForm" method="POST" action="<?php echo BASE_URL; ?>patient/bookAppointmentSubmit" 
                      class="p-8 space-y-8">
                    
                    <!-- Patient Identification -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-100 p-2 rounded-lg">
                                <i class="fas fa-id-card text-blue-600"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-800">Patient Identification</h2>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Patient ID or Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="patient_identifier" required
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                       placeholder="Enter Patient ID or Phone Number">
                            </div>
                            <p class="text-sm text-gray-600 mt-3 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Not registered yet? 
                                <a href="<?php echo BASE_URL; ?>patient/register" class="text-blue-600 hover:text-blue-800 font-medium ml-1">
                                    Register here first
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Doctor & Date Selection -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-100 p-2 rounded-lg">
                                <i class="fas fa-user-md text-green-600"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-800">Select Doctor & Time</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Doctor Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Select Doctor <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-stethoscope text-gray-400"></i>
                                    </div>
                                    <select name="doctor_id" required 
                                            class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition appearance-none">
                                        <option value="">Choose a Doctor</option>
                                        <?php foreach ($doctors as $doctor): ?>
                                        <option value="<?php echo $doctor['id']; ?>">
                                            Dr. <?php echo htmlspecialchars($doctor['name']); ?>
                                            <?php if ($doctor['specialization']): ?>
                                            - <?php echo htmlspecialchars($doctor['specialization']); ?>
                                            <?php endif; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Date Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Appointment Date <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-day text-gray-400"></i>
                                    </div>
                                    <input type="date" name="appointment_date" required 
                                           min="<?php echo date('Y-m-d'); ?>" 
                                           max="<?php echo date('Y-m-d', strtotime('+30 days')); ?>"
                                           class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition datepicker">
                                </div>
                            </div>
                            
                            <!-- Time Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Appointment Time <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                    <select name="appointment_time" required 
                                            class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition appearance-none">
                                        <option value="">Select Time Slot</option>
                                        <option value="08:00">08:00 AM - Morning</option>
                                        <option value="09:00">09:00 AM - Morning</option>
                                        <option value="10:00">10:00 AM - Morning</option>
                                        <option value="11:00">11:00 AM - Morning</option>
                                        <option value="14:00">02:00 PM - Afternoon</option>
                                        <option value="15:00">03:00 PM - Afternoon</option>
                                        <option value="16:00">04:00 PM - Afternoon</option>
                                        <option value="17:00">05:00 PM - Evening</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Doctor Availability -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Doctor Availability</label>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                                        <div>
                                            <p class="text-sm text-gray-700">Available time slots are shown</p>
                                            <p class="text-xs text-gray-600 mt-1">Each appointment: 30 minutes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Appointment Details -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-purple-100 p-2 rounded-lg">
                                <i class="fas fa-file-medical-alt text-purple-600"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-800">Appointment Details</h2>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Reason for Visit <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3">
                                    <i class="fas fa-comment-medical text-gray-400"></i>
                                </div>
                                <textarea name="reason" rows="4" required
                                          class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                          placeholder="Please describe the reason for your visit in detail..."></textarea>
                            </div>
                            <div class="mt-2 text-sm text-gray-600 flex items-center">
                                <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>
                                Be specific to help the doctor prepare for your visit
                            </div>
                        </div>
                        
                        <!-- Symptoms Checklist -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Common Symptoms (Optional)</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <?php 
                                $symptoms = ['Fever', 'Headache', 'Cough', 'Fatigue', 'Nausea', 'Pain', 'Dizziness', 'Other'];
                                foreach ($symptoms as $symptom): 
                                ?>
                                <label class="flex items-center space-x-2 p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="symptoms[]" value="<?php echo $symptom; ?>" 
                                           class="rounded text-green-600 focus:ring-green-500">
                                    <span class="text-sm text-gray-700"><?php echo $symptom; ?></span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Summary Card -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-receipt mr-2 text-blue-600"></i>
                            Appointment Summary
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Consultation Fee:</span>
                                    <span class="font-medium text-gray-800">LKR 2,500.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Service Charge:</span>
                                    <span class="font-medium text-gray-800">LKR 250.00</span>
                                </div>
                                <div class="flex justify-between pt-3 border-t">
                                    <span class="text-gray-800 font-semibold">Estimated Total:</span>
                                    <span class="text-green-600 font-bold text-lg">LKR 2,750.00</span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Digital prescription included</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Follow-up consultation available</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Insurance accepted</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="pt-8 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                            <a href="<?php echo BASE_URL; ?>patient/register" 
                               class="flex items-center text-blue-600 hover:text-blue-800 transition">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Registration
                            </a>
                            
                            <div class="flex space-x-4">
                                <button type="button" onclick="clearAppointmentForm()"
                                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                                    Reset Form
                                </button>
                                <button type="submit"
                                        class="px-6 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 text-sm font-medium shadow-sm hover:shadow">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Confirm Appointment
                                </button>
                            </div>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">
                                Need to check an existing appointment? 
                                <a href="<?php echo BASE_URL; ?>patient/check-appointment" class="text-green-600 hover:text-green-800 font-medium">
                                    Check status here
                                </a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Form validation and interactivity
    function clearAppointmentForm() {
        if (confirm('Are you sure you want to reset the form?')) {
            document.getElementById('appointmentForm').reset();
        }
    }
    
    // Date restrictions
    const today = new Date().toISOString().split('T')[0];
    const maxDate = new Date();
    maxDate.setDate(maxDate.getDate() + 30);
    const maxDateStr = maxDate.toISOString().split('T')[0];
    
    document.querySelector('input[name="appointment_date"]').min = today;
    document.querySelector('input[name="appointment_date"]').max = maxDateStr;
    
    // Form validation
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        const patientId = document.querySelector('input[name="patient_identifier"]');
        const doctor = document.querySelector('select[name="doctor_id"]');
        const date = document.querySelector('input[name="appointment_date"]');
        const time = document.querySelector('select[name="appointment_time"]');
        const reason = document.querySelector('textarea[name="reason"]');
        
        // Validate required fields
        if (!patientId.value.trim()) {
            e.preventDefault();
            alert('Please enter your Patient ID or Phone Number');
            patientId.focus();
            return false;
        }
        
        if (!doctor.value) {
            e.preventDefault();
            alert('Please select a doctor');
            doctor.focus();
            return false;
        }
        
        if (!date.value) {
            e.preventDefault();
            alert('Please select an appointment date');
            date.focus();
            return false;
        }
        
        if (!time.value) {
            e.preventDefault();
            alert('Please select an appointment time');
            time.focus();
            return false;
        }
        
        if (!reason.value.trim()) {
            e.preventDefault();
            alert('Please describe the reason for your visit');
            reason.focus();
            return false;
        }
        
        // Check if date is not a Sunday
        const selectedDate = new Date(date.value);
        if (selectedDate.getDay() === 0) {
            e.preventDefault();
            alert('Sorry, appointments are not available on Sundays. Please select another day.');
            date.focus();
            return false;
        }
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Booking...';
        submitBtn.disabled = true;
        
        // Show confirmation
        if (!confirm('Are you sure you want to book this appointment?')) {
            e.preventDefault();
            submitBtn.innerHTML = '<i class="fas fa-calendar-check mr-2"></i> Confirm Appointment';
            submitBtn.disabled = false;
            return false;
        }
    });
    
    // Real-time date validation
    document.querySelector('input[name="appointment_date"]').addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const day = selectedDate.getDay();
        
        if (day === 0) { // Sunday
            alert('Note: The clinic is closed on Sundays. Please select another day.');
        }
    });
</script>

<style>
    .datepicker::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }
    
    input[type="checkbox"]:checked {
        background-color: #10B981;
        border-color: #10B981;
    }
    
    .transition {
        transition: all 0.3s ease;
    }
    
    .shadow-lg {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .shadow-xl {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>