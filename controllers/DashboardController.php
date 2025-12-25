<?php
// medico/controllers/DashboardController.php

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/includes/Auth.php';
require_once dirname(__DIR__) . '/includes/Session.php';
require_once dirname(__DIR__) . '/config/Database.php';

class DashboardController
{
    private $auth;
    private $session;
    private $db;

    public function __construct()
    {
        $this->auth = new Auth();
        $this->session = new Session();
        $this->db = (new Database())->connect();

        // Require login for all dashboard pages
        if (!$this->auth->isLoggedIn()) {
            $this->session->setFlash('error', 'Please login first.');
            header('Location: ' . BASE_URL . 'index.php?url=auth/login');
            exit();
        }
    }

    public function index()
    {
        // Debug: Check if constants are loaded
        if (!defined('ROLE_SUPER_ADMIN')) {
            die("ERROR: Constants not loaded. ROLE_SUPER_ADMIN is not defined.");
        }

        // Get user role
        $role = $this->session->get('role');

        switch ($role) {
            case ROLE_SUPER_ADMIN:
                $this->superAdminDashboard();
                break;
            case ROLE_DOCTOR:
                $this->doctorDashboard();
                break;
            case ROLE_RECEPTIONIST:
                $this->receptionistDashboard();
                break;
            case ROLE_PHARMACIST:
                $this->pharmacistDashboard();
                break;
            default:
                // Generic dashboard
                $this->genericDashboard();
        }
    }

    private function superAdminDashboard()
    {
        // Get stats with default values
        $stats = [
            'total_users' => $this->getTotalUsers(),
            'total_patients' => $this->getTotalPatients(),
            'total_appointments' => $this->getTotalAppointments(),
            'total_prescriptions' => $this->getTotalPrescriptions()
        ];

        // Get recent users
        $recentUsers = $this->getRecentUsers();

        // Load the view
        $title = 'Super Admin Dashboard';
        $showNavbar = false;

        // Make variables available to view
        extract([
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'title' => $title
        ]);
        // 
        // Start output buffering
        ob_start();
        include dirname(__DIR__) . '/views/dashboard/super-admin.php';
        // $content = ob_get_clean();

        // Include layout
        // include dirname(__DIR__) . '/views/layouts/main.php';
    }

    private function doctorDashboard()
    {
        $doctor_id = $this->session->get('user_id');

        $stats = [
            'today_appointments' => $this->getTodayAppointments($doctor_id),
            'total_patients' => $this->getDoctorPatients($doctor_id),
            'pending_prescriptions' => $this->getPendingPrescriptions($doctor_id)
        ];

        $title = 'Doctor Dashboard';
        $showNavbar = true;
        // Get today's schedule
        $todaySchedule = $this->getTodaySchedule($doctor_id);

        // Get recent patients
        $recentPatients = $this->getDoctorPatientList($doctor_id, 5);

        // Pass variables to view
        extract([
            'stats' => $stats,
            'title' => $title,
            'showNavbar' => $showNavbar,
            'todaySchedule' => $todaySchedule,
            'recentPatients' => $recentPatients,
        ]);

        ob_start();
        include dirname(__DIR__) . '/views/dashboard/doctor.php';
        $content = ob_get_clean();
        include dirname(__DIR__) . '/views/layouts/main.php';
    }

    private function receptionistDashboard()
    {
        $stats = [
            'new_patients_today' => $this->getNewPatientsToday(),
            'today_appointments' => $this->getAllTodayAppointments(),
            'pending_bills' => $this->getPendingBills()
        ];

        $title = 'Receptionist Dashboard';
        $showNavbar = true;

        extract([
            'stats' => $stats,
            'title' => $title,
            'showNavbar' => $showNavbar
        ]);

        ob_start();
        include dirname(__DIR__) . '/views/dashboard/receptionist.php';
        $content = ob_get_clean();
        include dirname(__DIR__) . '/views/layouts/main.php';
    }

    private function pharmacistDashboard()
    {
        $stats = [
            'low_stock' => $this->getLowStockMedicines(),
            'pending_prescriptions' => $this->getAllPendingPrescriptions(),
            'today_sales' => $this->getTodaySales()
        ];

        $title = 'Pharmacist Dashboard';
        $showNavbar = true;

        extract([
            'stats' => $stats,
            'title' => $title,
            'showNavbar' => $showNavbar
        ]);

        ob_start();
        include dirname(__DIR__) . '/views/dashboard/pharmacist.php';
        $content = ob_get_clean();
        include dirname(__DIR__) . '/views/layouts/main.php';
    }

    private function genericDashboard()
    {
        $title = 'Dashboard';
        $showNavbar = true;

        extract([
            'title' => $title,
            'showNavbar' => $showNavbar
        ]);

        ob_start();
?>
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-800">Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?>!</h1>
            <p class="text-gray-600">Role: <?php echo htmlspecialchars($_SESSION['role_name']); ?></p>
            <div class="mt-4">
                <a href="<?php echo BASE_URL; ?>index.php?url=auth/logout" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
            </div>
        </div>
<?php
        $content = ob_get_clean();
        include dirname(__DIR__) . '/views/layouts/main.php';
    }

    // ============ STATISTICS METHODS ============

  
    private function getTotalUsers()
    {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM users");
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getTotalUsers: " . $e->getMessage());
            return 0;
        }
    }

    private function getTotalPatients()
    {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM patients");
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getTotalPatients: " . $e->getMessage());
            return 0;
        }
    }

    private function getTotalAppointments()
    {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM appointments");
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getTotalAppointments: " . $e->getMessage());
            return 0;
        }
    }

    private function getTotalPrescriptions()
    {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM prescriptions");
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getTotalPrescriptions: " . $e->getMessage());
            return 0;
        }
    }

    private function getRecentUsers($limit = 5)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT u.*, r.role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                ORDER BY u.created_at DESC 
                LIMIT ?
            ");
            $stmt->execute([$limit]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error in getRecentUsers: " . $e->getMessage());
            return [];
        }
    }

    private function getTodayAppointments($doctor_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as count 
                FROM appointments 
                WHERE doctor_id = ? AND appointment_date = CURDATE()
            ");
            $stmt->execute([$doctor_id]);
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getTodayAppointments: " . $e->getMessage());
            return 0;
        }
    }

    private function getDoctorPatients($doctor_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(DISTINCT patient_id) as count 
                FROM appointments 
                WHERE doctor_id = ?
            ");
            $stmt->execute([$doctor_id]);
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getDoctorPatients: " . $e->getMessage());
            return 0;
        }
    }

    private function getPendingPrescriptions($doctor_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as count 
                FROM prescriptions 
                WHERE doctor_id = ? AND status = 'Pending'
            ");
            $stmt->execute([$doctor_id]);
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getPendingPrescriptions: " . $e->getMessage());
            return 0;
        }
    }

    private function getNewPatientsToday()
    {
        try {
            $stmt = $this->db->query("
                SELECT COUNT(*) as count 
                FROM patients 
                WHERE DATE(created_at) = CURDATE()
            ");
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getNewPatientsToday: " . $e->getMessage());
            return 0;
        }
    }

    private function getAllTodayAppointments()
    {
        try {
            $stmt = $this->db->query("
                SELECT COUNT(*) as count 
                FROM appointments 
                WHERE appointment_date = CURDATE()
            ");
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getAllTodayAppointments: " . $e->getMessage());
            return 0;
        }
    }

    private function getPendingBills()
    {
        try {
            $stmt = $this->db->query("
                SELECT COUNT(*) as count 
                FROM billing 
                WHERE payment_status IN ('Pending', 'Partial')
            ");
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getPendingBills: " . $e->getMessage());
            return 0;
        }
    }

    private function getLowStockMedicines()
    {
        try {
            $stmt = $this->db->query("
                SELECT COUNT(*) as count 
                FROM medicines 
                WHERE stock_quantity <= reorder_level AND is_active = 1
            ");
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getLowStockMedicines: " . $e->getMessage());
            return 0;
        }
    }

    private function getAllPendingPrescriptions()
    {
        try {
            $stmt = $this->db->query("
                SELECT COUNT(*) as count 
                FROM prescriptions 
                WHERE status = 'Pending'
            ");
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getAllPendingPrescriptions: " . $e->getMessage());
            return 0;
        }
    }

    private function getTodaySales()
    {
        try {
            $stmt = $this->db->query("
                SELECT COALESCE(SUM(total_amount), 0) as total 
                FROM billing 
                WHERE DATE(billing_date) = CURDATE() AND payment_status = 'Paid'
            ");
            $result = $stmt->fetch();
            return number_format($result['total'] ?? 0, 2);
        } catch (Exception $e) {
            error_log("Error in getTodaySales: " . $e->getMessage());
            return '0.00';
        }
    }

    // These are optional - you can implement them later
    private function getTodaySchedule($doctor_id)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT 
                a.*,
                p.first_name as patient_first_name,
                p.last_name as patient_last_name,
                CONCAT(p.first_name, ' ', p.last_name) as patient_name,
                p.phone,
                p.email
            FROM appointments a
            JOIN patients p ON a.patient_id = p.id
            WHERE a.doctor_id = ? 
            AND a.appointment_date = CURDATE()
            AND a.status != 'Cancelled'
            ORDER BY a.appointment_time ASC
        ");
            $stmt->execute([$doctor_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error in getTodaySchedule: " . $e->getMessage());
            return [];
        }
    }

    private function getDoctorPatientList($doctor_id, $limit = 10)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT DISTINCT 
                p.*,
                COUNT(a.id) as appointment_count,
                MAX(a.appointment_date) as last_visit
            FROM patients p
            JOIN appointments a ON p.id = a.patient_id
            WHERE a.doctor_id = ?
            GROUP BY p.id
            ORDER BY last_visit DESC
            LIMIT ?
        ");
            $stmt->execute([$doctor_id, $limit]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error in getDoctorPatientList: " . $e->getMessage());
            return [];
        }
    }

    private function getRecentPatients()
    {
        return [];
    }

    private function getExpiringMedicines()
    {
        return [];
    }
}
