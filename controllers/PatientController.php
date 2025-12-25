<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/config/Database.php';

class PatientController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    // Public patient registration form
    public function registerForm()
    {
        $title = 'Patient Registration';
        $showNavbar = false; // Use public layout

        ob_start();
        include dirname(__DIR__) . '/views/patient/register.php';
        $content = ob_get_clean();

        include dirname(__DIR__) . '/views/layouts/public.php';
    }

    // Handle patient registration
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Generate unique patient ID
            $patient_id = 'PAT-' . date('Ymd') . '-' . rand(1000, 9999);

            try {
                // Check if email already exists
                if (!empty($_POST['email'])) {
                    // var_dump($_POST['email']);
                    // exit();
                    $checkStmt = $this->db->prepare("SELECT id FROM patients WHERE email = ?");
                    $checkStmt->execute([$_POST['email']]);
                    if ($checkStmt->fetch()) {
                        $_SESSION['flash']['error'] = 'Email already registered. Please use a different email.';
                        header('Location: ' . BASE_URL . 'patient/register');
                        exit();
                    }
                }

                // Insert patient
                $stmt = $this->db->prepare("
                    INSERT INTO `patients` (
                        `patient_id`, `first_name`, last_name, date_of_birth, gender,
                        `phone`, `email`, `address`, `emergency_contact_name`, `emergency_contact_phone`,
                        `blood_group`, `medical_history`, `allergies`, `created_by`
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                // Get current admin user ID or use 2 as default
                $created_by = 2; // Default admin user
                if (isset($_SESSION['user_id'])) {
                    $created_by = $_SESSION['user_id'];
                    // var_dump($created_by);
                    // exit();
                }

                $stmt->execute([
                    $patient_id,
                    $_POST['first_name'],
                    $_POST['last_name'],
                    $_POST['date_of_birth'],
                    $_POST['gender'],
                    $_POST['phone'],
                    $_POST['email'] ?? null,
                    $_POST['address'] ?? null,
                    $_POST['emergency_contact_name'] ?? null,
                    $_POST['emergency_contact_phone'] ?? null,
                    $_POST['blood_group'] ?? null,
                    $_POST['medical_history'] ?? null,
                    $_POST['allergies'] ?? null,
                    $created_by
                ]);

                $patient_id_db = $this->db->lastInsertId();
                $_SESSION['registered_patient'] = [
                    'id' => $patient_id_db,
                    'patient_id' => $patient_id,
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'phone' => $_POST['phone']
                ];
                // var_dump($patient_id_db);
                // exit();
                $_SESSION['flash']['success'] = 'Registration successful! Your Patient ID is: ' . $patient_id;
                $_SESSION['registered_patient_id'] = $patient_id_db;

                // Redirect to appointment booking
                header('Location: ' . BASE_URL . 'patient/bookAppointmentForm');
                exit();
            } catch (PDOException $e) {
                $_SESSION['flash']['error'] = 'Registration failed. Please try again.';
                header('Location: ' . BASE_URL . 'patient/register');
                exit();
            }
        }
    }

    // Book appointment form
    public function bookAppointmentForm()
    {
        // Get available doctors
        $doctors = $this->getAvailableDoctors();

        // Get registered patient data from session
        $registeredPatient = $_SESSION['registered_patient'] ?? null;

        $title = 'Book Appointment';
        $showNavbar = false;

        ob_start();
        include dirname(__DIR__) . '/views/patient/book-appointment.php';
        $content = ob_get_clean();

        include dirname(__DIR__) . '/views/layouts/public.php';
    }

    // Handle appointment booking
    public function bookAppointment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Generate appointment number
                $appointment_number = 'APT-' . date('Ymd') . '-' . rand(1000, 9999);

                // Check if patient exists
                $patientStmt = $this->db->prepare("SELECT id FROM patients WHERE patient_id = ? OR phone = ?");
                $patientStmt->execute([$_POST['patient_identifier'], $_POST['patient_identifier']]);
                $patient = $patientStmt->fetch();

                if (!$patient) {
                    $_SESSION['flash']['error'] = 'Patient not found. Please register first.';
                    header('Location: ' . BASE_URL . 'patient/register');
                    exit();
                }

                // Check doctor availability
                $doctorStmt = $this->db->prepare("
                    SELECT COUNT(*) as count 
                    FROM appointments 
                    WHERE doctor_id = ? 
                    AND appointment_date = ? 
                    AND appointment_time = ?
                    AND status IN ('Scheduled', 'Confirmed')
                ");
                $doctorStmt->execute([$_POST['doctor_id'], $_POST['appointment_date'], $_POST['appointment_time']]);
                $existing = $doctorStmt->fetch();

                if ($existing['count'] > 0) {
                    $_SESSION['flash']['error'] = 'Selected time slot is not available. Please choose another time.';
                    header('Location: ' . BASE_URL . 'patient/bookAppointmentForm');
                    exit();
                }

                // Insert appointment
                $stmt = $this->db->prepare("
                    INSERT INTO appointments (
                        appointment_number, patient_id, doctor_id, appointment_date,
                        appointment_time, reason, status, created_by
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $created_by = 2; // Default admin user
                if (isset($_SESSION['user_id'])) {
                    $created_by = $_SESSION['user_id'];
                }

                $stmt->execute([
                    $appointment_number,
                    $patient['id'],
                    $_POST['doctor_id'],
                    $_POST['appointment_date'],
                    $_POST['appointment_time'],
                    $_POST['reason'] ?? null,
                    'Scheduled',
                    $created_by
                ]);

                $appointment_id = $this->db->lastInsertId();

                $_SESSION['flash']['success'] = 'Appointment booked successfully! Your Appointment Number is: ' . $appointment_number;
                $_SESSION['appointment_number'] = $appointment_number;

                header('Location: ' . BASE_URL . 'patient/appointmentSuccess');
                exit();
            } catch (PDOException $e) {
                $_SESSION['flash']['error'] = 'Appointment booking failed. Please try again.';
                header('Location: ' . BASE_URL . 'patient/bookAppointmentForm');
                exit();
            }
        }
    }

    // Appointment success page
    public function appointmentSuccess()
    {
        $title = 'Appointment Booked Successfully';
        $showNavbar = false;

        $appointment_number = $_SESSION['appointment_number'] ?? '';

        ob_start();
        include dirname(__DIR__) . '/views/patient/appointment-success.php';
        $content = ob_get_clean();

        include dirname(__DIR__) . '/views/layouts/public.php';
    }

    // Check appointment status form
    public function checkAppointmentForm()
    {
        $title = 'Check Appointment Status';
        $showNavbar = false;

        ob_start();
        include dirname(__DIR__) . '/views/patient/check-appointment.php';
        $content = ob_get_clean();

        include dirname(__DIR__) . '/views/layouts/public.php';
    }

    // Handle appointment status check
    public function checkAppointment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment_number = $_POST['appointment_number'] ?? '';
            $phone = $_POST['phone'] ?? '';

            $stmt = $this->db->prepare("
                SELECT a.*, p.first_name, p.last_name, p.phone,
                       CONCAT(u.first_name, ' ', u.last_name) as doctor_name
                FROM appointments a
                JOIN patients p ON a.patient_id = p.id
                JOIN users u ON a.doctor_id = u.id
                WHERE a.appointment_number = ? AND p.phone = ?
            ");

            $stmt->execute([$appointment_number, $phone]);
            $appointment = $stmt->fetch();

            $title = 'Appointment Status';
            $showNavbar = false;

            ob_start();
            include dirname(__DIR__) . '/views/patient/appointment-status.php';
            $content = ob_get_clean();

            include dirname(__DIR__) . '/views/layouts/public.php';
        }
    }

    // Helper method to get available doctors
    private function getAvailableDoctors()
    {
        $stmt = $this->db->query("
            SELECT id, CONCAT(first_name, ' ', last_name) as name, specialization
            FROM users 
            WHERE role_id = (SELECT id FROM roles WHERE role_name = 'Doctor')
            AND is_active = 1
            ORDER BY first_name
        ");
        return $stmt->fetchAll();
    }
}
