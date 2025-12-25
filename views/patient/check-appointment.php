<div class="min-h-screen bg-gradient-to-br from-blue-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-8 text-white text-center">
                    <h1 class="text-3xl font-bold">Check Appointment Status</h1>
                    <p class="text-blue-100 mt-2">View your appointment details and status</p>
                </div>

                <!-- Form -->
                <form method="POST" action="<?php echo BASE_URL; ?>patient/checkAppointment" class="p-8 space-y-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Appointment Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-ticket-alt text-gray-400"></i>
                                </div>
                                <input type="text" name="appointment_number" required
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                       placeholder="Enter your appointment number (e.g., APT-20251225-1234)">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" name="phone" required
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                       placeholder="Enter the phone number used during registration">
                            </div>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                            <div>
                                <h4 class="text-sm font-medium text-blue-800">How to find your details</h4>
                                <ul class="mt-2 text-sm text-blue-700 space-y-1">
                                    <li>• Appointment number was provided after booking</li>
                                    <li>• Use the phone number registered with us</li>
                                    <li>• Check your email/SMS for confirmation</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="pt-6">
                        <button type="submit"
                                class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium shadow-sm hover:shadow">
                            <i class="fas fa-search mr-2"></i>
                            Check Status
                        </button>
                        
                        <div class="mt-6 text-center space-y-3">
                            <p class="text-sm text-gray-600">
                                Don't have an appointment number?
                                <a href="<?php echo BASE_URL; ?>patient/bookAppointmentForm" class="text-blue-600 hover:text-blue-800 font-medium ml-1">
                                    Book an appointment
                                </a>
                            </p>
                            <p class="text-sm text-gray-600">
                                Not registered yet?
                                <a href="<?php echo BASE_URL; ?>patient/register" class="text-blue-600 hover:text-blue-800 font-medium ml-1">
                                    Register as patient
                                </a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Help Section -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-green-600"></i>
                    </div>
                    <h3 class="font-medium text-gray-800 mb-2">Need Help?</h3>
                    <p class="text-sm text-gray-600">Call us at +94 11 234 5678</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-blue-600"></i>
                    </div>
                    <h3 class="font-medium text-gray-800 mb-2">Email Support</h3>
                    <p class="text-sm text-gray-600">info@medico.lk</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-purple-600"></i>
                    </div>
                    <h3 class="font-medium text-gray-800 mb-2">Working Hours</h3>
                    <p class="text-sm text-gray-600">Mon-Sat: 8AM-8PM</p>
                </div>
            </div>
        </div>
    </div>
</div>