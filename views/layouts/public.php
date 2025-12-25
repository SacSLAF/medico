<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' | ' . APP_NAME : APP_NAME; ?></title>

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/tailwind.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        .flash-message {
            animation: fadeOut 5s forwards;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Public Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?php echo BASE_URL; ?>patient/registerForm" class="flex items-center">
                        <div class="h-8 w-8 bg-blue-600 rounded-md flex items-center justify-center">
                            <i class="fas fa-heartbeat text-white"></i>
                        </div>
                        <span class="ml-2 text-xl font-bold text-gray-800">
                            <span class="block leading-tight">Medico</span>
                            <span class="text-xs block leading-tight text-gray-600">Clinic & Hospital</span>
                        </span>
                    </a>
                </div>

                <!-- Public Navigation Links -->
                <!-- Public Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?php echo BASE_URL; ?>patient/registerForm"
                        class="text-gray-700 hover:text-blue-600 font-medium px-3 py-2 rounded-md hover:bg-blue-50 transition-colors duration-200">
                        <i class="fas fa-user-plus mr-2"></i>
                        Registration
                    </a>

                    <a href="<?php echo BASE_URL; ?>patient/bookAppointmentForm"
                        class="text-gray-700 hover:text-green-600 font-medium px-3 py-2 rounded-md hover:bg-green-50 transition-colors duration-200">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Book Appointment
                    </a>

                    <a href="<?php echo BASE_URL; ?>patient/checkAppointmentForm"
                        class="text-gray-700 hover:text-purple-600 font-medium px-3 py-2 rounded-md hover:bg-purple-50 transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>
                        Check Status
                    </a>

                    <div class="h-6 w-px bg-gray-300 mx-2"></div>

                    <a href="<?php echo BASE_URL; ?>auth/login"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium shadow-sm hover:shadow min-w-[120px] inline-flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Staff Login
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="md:hidden hidden py-4 border-t border-gray-200">
                <div class="space-y-2 px-4">
                    <a href="<?php echo BASE_URL; ?>patient/registerForm"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-md transition-colors">
                        <i class="fas fa-user-plus mr-3 w-5 text-center"></i>
                        Patient Registration
                    </a>

                    <a href="<?php echo BASE_URL; ?>patient/bookAppointmentForm"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md transition-colors">
                        <i class="fas fa-calendar-check mr-3 w-5 text-center"></i>
                        Book Appointment
                    </a>

                    <a href="<?php echo BASE_URL; ?>patient/checkAppointmentForm"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-md transition-colors">
                        <i class="fas fa-search mr-3 w-5 text-center"></i>
                        Check Appointment
                    </a>

                    <a href="<?php echo BASE_URL; ?>auth/login"
                        class="flex items-center px-4 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 mt-4">
                        <i class="fas fa-sign-in-alt mr-3 w-5 text-center"></i>
                        Staff Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        <?php
        // Display flash messages
        if (isset($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $type => $message) {
                $bgColor = $type == 'success' ? 'bg-green-100 border-green-400 text-green-700' : ($type == 'error' ? 'bg-red-100 border-red-400 text-red-700' :
                    'bg-blue-100 border-blue-400 text-blue-700');
                echo "<div class='flash-message $bgColor border px-4 py-3 rounded mx-4 mt-4'>" .
                    htmlspecialchars($message) . "</div>";
                unset($_SESSION['flash'][$type]);
            }
        }
        ?>

        <?php echo $content ?? ''; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-12">

            <!-- Bottom Section -->
            <div class="border-t border-gray-200 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <!-- Copyright -->
                    <div class="text-gray-600">
                        <p class="text-sm">&copy; <?php echo date('Y'); ?> Medico Clinic & Hospital. All rights reserved.</p>
                        <p class="text-xs text-gray-500 mt-1">Providing healthcare excellence since 2010</p>
                    </div>

                    <!-- Social Links -->
                    <div class="flex items-center space-x-1">
                        <span class="text-sm text-gray-600 mr-3">Follow us:</span>
                        <div class="flex items-center space-x-3">
                            <a href="#" class="text-gray-500 hover:text-blue-600 transition-colors duration-200 p-2 hover:bg-blue-50 rounded-full">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-blue-400 transition-colors duration-200 p-2 hover:bg-blue-50 rounded-full">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-pink-600 transition-colors duration-200 p-2 hover:bg-pink-50 rounded-full">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-blue-700 transition-colors duration-200 p-2 hover:bg-blue-50 rounded-full">
                                <i class="fab fa-linkedin-in text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Legal Links -->
                    <div class="flex items-center space-x-4 text-sm">
                        <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">Privacy Policy</a>
                        <span class="text-gray-300">|</span>
                        <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">Terms of Service</a>
                        <span class="text-gray-300">|</span>
                        <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Auto-hide flash messages
        setTimeout(() => {
            document.querySelectorAll('.flash-message').forEach(msg => {
                msg.style.display = 'none';
            });
        }, 5000);

        // Close flash message on click
        document.querySelectorAll('.flash-message').forEach(msg => {
            msg.addEventListener('click', function() {
                this.style.display = 'none';
            });
        });
    </script>
</body>

</html>