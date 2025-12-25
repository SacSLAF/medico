<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 flex items-center justify-center px-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Success Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-8 py-10 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-blue">Appointment Booked Successfully!</h1>
                <p class="text-green-500 mt-2">Your appointment has been confirmed</p>
            </div>

            <!-- Appointment Details -->
            <div class="p-8 space-y-6">
                <!-- Success Message -->
                <div class="text-center mb-8">
                    <h2 class="text-xl font-semibold text-gray-800">Thank you for choosing Medico Clinic</h2>
                    <p class="text-gray-600 mt-2">Your appointment has been scheduled successfully. Please save your appointment number for future reference.</p>
                </div>

                <!-- Appointment Card -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Appointment Details</h3>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">Confirmed</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm text-gray-500">Appointment Number</span>
                                <div class="mt-1">
                                    <code class="bg-gray-800 text-blue px-4 py-2 rounded-lg text-lg font-mono font-bold inline-block">
                                        <?php echo htmlspecialchars($appointment_number); ?>
                                    </code>
                                </div>
                                <p class="text-xs text-gray-600 mt-2">Save this number for future reference</p>
                            </div>
                            
                            <div>
                                <span class="text-sm text-gray-500">Status</span>
                                <p class="text-green-600 font-medium mt-1">Scheduled ✓</p>
                            </div>
                            
                            <div>
                                <span class="text-sm text-gray-500">Date & Time</span>
                                <p class="text-gray-800 font-medium mt-1">
                                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                    <?php echo isset($_SESSION['appointment_date']) ? date('F j, Y', strtotime($_SESSION['appointment_date'])) : 'To be confirmed'; ?>
                                </p>
                                <p class="text-gray-800 font-medium">
                                    <i class="fas fa-clock mr-2 text-blue-500"></i>
                                    <?php echo isset($_SESSION['appointment_time']) ? date('h:i A', strtotime($_SESSION['appointment_time'])) : 'To be confirmed'; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm text-gray-500">Important Notes</span>
                                <ul class="mt-2 space-y-2 text-sm text-gray-700">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                        <span>Arrive 15 minutes before your appointment</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                        <span>Bring your ID and insurance card</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                        <span>Cancel at least 24 hours in advance if needed</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="pt-4 border-t border-gray-200">
                                <span class="text-sm text-gray-500">Need Help?</span>
                                <p class="text-sm text-gray-700 mt-1">
                                    Contact us: <span class="font-medium">+94 11 234 5678</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <a href="<?php echo BASE_URL; ?>patient/checkAppointmentForm" 
                       class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium text-center">
                        <i class="fas fa-search mr-2"></i>
                        Check Appointment Status
                    </a>
                    
                    <button onclick="printAppointmentDetails()"
                            class="flex-1 border border-blue-600 text-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50 transition-colors duration-200 font-medium">
                        <i class="fas fa-print mr-2"></i>
                        Print Details
                    </button>
                    
                    <a href="<?php echo BASE_URL; ?>patient/bookAppointmentForm" 
                       class="flex-1 border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium text-center">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Book Another
                    </a>
                </div>

                <!-- Quick Links -->
                <div class="pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">What to do next?</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="<?php echo BASE_URL; ?>" 
                           class="p-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-center transition-colors">
                            <i class="fas fa-home text-blue-500 text-lg mb-2"></i>
                            <p class="text-sm font-medium text-gray-800">Return Home</p>
                        </a>
                        
                        <a href="<?php echo BASE_URL; ?>patient/checkAppointmentForm" 
                           class="p-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-center transition-colors">
                            <i class="fas fa-file-medical text-green-500 text-lg mb-2"></i>
                            <p class="text-sm font-medium text-gray-800">View Details</p>
                        </a>
                        
                        <a href="<?php echo BASE_URL; ?>patient/registerForm" 
                           class="p-3 bg-gray-50 hover:bg-gray-100 rounded-lg text-center transition-colors">
                            <i class="fas fa-user-plus text-purple-500 text-lg mb-2"></i>
                            <p class="text-sm font-medium text-gray-800">Register Another</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Reminder -->
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p>You will receive a confirmation email/SMS shortly. If you don't receive it within 30 minutes, please contact us.</p>
        </div>
    </div>
</div>

<script>
    function printAppointmentDetails() {
        const printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Appointment Confirmation - Medico Clinic</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .appointment-number { 
                        background: #f3f4f6; 
                        padding: 10px; 
                        font-family: monospace; 
                        font-size: 18px;
                        font-weight: bold;
                        text-align: center;
                        margin: 10px 0;
                        border-radius: 5px;
                    }
                    .details { margin: 20px 0; }
                    .section { margin-bottom: 15px; }
                    .label { font-weight: bold; color: #666; }
                    .value { margin-left: 10px; }
                    .instructions { margin-top: 30px; font-size: 14px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>Medico Clinic - Appointment Confirmation</h1>
                    <p>Your appointment has been booked successfully</p>
                </div>
                
                <div class="appointment-number"><?php echo htmlspecialchars($appointment_number); ?></div>
                
                <div class="details">
                    <div class="section">
                        <span class="label">Status:</span>
                        <span class="value">Scheduled ✓</span>
                    </div>
                    <div class="section">
                        <span class="label">Date:</span>
                        <span class="value">${document.querySelector('[class*="fa-calendar-alt"]').parentElement.textContent.trim()}</span>
                    </div>
                    <div class="section">
                        <span class="label">Time:</span>
                        <span class="value">${document.querySelector('[class*="fa-clock"]').parentElement.textContent.trim()}</span>
                    </div>
                </div>
                
                <div class="instructions">
                    <h3>Important Instructions:</h3>
                    <ul>
                        <li>Arrive 15 minutes before your appointment time</li>
                        <li>Bring your ID and insurance card</li>
                        <li>Cancel at least 24 hours in advance if needed</li>
                        <li>Contact: +94 11 234 5678 for any queries</li>
                    </ul>
                </div>
                
                <p style="margin-top: 30px; font-size: 12px; color: #666;">
                    Generated on: ${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}
                </p>
            </body>
            </html>
        `;
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.print();
    }
    
    // Copy appointment number to clipboard
    function copyAppointmentNumber() {
        const appointmentNumber = '<?php echo $appointment_number; ?>';
        navigator.clipboard.writeText(appointmentNumber).then(() => {
            alert('Appointment number copied to clipboard!');
        });
    }
</script>