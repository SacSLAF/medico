<?php

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/includes/Auth.php';
require_once dirname(__DIR__) . '/includes/Session.php';
require_once dirname(__DIR__) . '/config/Database.php';

class ReportsController
{
    private $auth;
    private $session;
    private $db;

    public function __construct()
    {
        $this->auth = new Auth();
        $this->session = new Session();
        $this->db = (new Database())->connect();

        // Require login
        if (!$this->auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }

        // Only Super Admin, Doctor, and Receptionist can view reports
        $allowed_roles = [ROLE_SUPER_ADMIN, ROLE_DOCTOR, ROLE_RECEPTIONIST];
        if (!in_array($this->session->get('role'), $allowed_roles)) {
            $this->session->setFlash('error', 'Access denied. Insufficient permissions.');
            header('Location: ' . BASE_URL . 'dashboard');
            exit();
        }
    }

    // Main reports dashboard
    public function index()
    {
        // Get date range (default: last 30 days)
        $start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $end_date = $_GET['end_date'] ?? date('Y-m-d');

        // Get statistics
        $stats = $this->getStatistics($start_date, $end_date);
        $dailyStats = $this->getDailyStatistics($start_date, $end_date);
        $topDoctors = $this->getTopDoctors($start_date, $end_date);
        $revenueData = $this->getRevenueData($start_date, $end_date);

        $title = 'View Reports';
        $showNavbar = true;

        include dirname(__DIR__) . '/views/reports/index.php';
    }

    // Patient reports
    public function patients()
    {
        $start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $end_date = $_GET['end_date'] ?? date('Y-m-d');

        $patientStats = $this->getPatientStatistics($start_date, $end_date);
        $newPatients = $this->getNewPatients($start_date, $end_date);

        $title = 'Patient Reports';
        $showNavbar = true;

        include dirname(__DIR__) . '/views/reports/patients.php';
    }

    // Financial reports
    public function financial()
    {
        $start_date = $_GET['start_date'] ?? date('Y-m-01'); // Start of current month
        $end_date = $_GET['end_date'] ?? date('Y-m-d');

        $revenueStats = $this->getRevenueStatistics($start_date, $end_date);
        $paymentMethods = $this->getPaymentMethodStats($start_date, $end_date);
        $topServices = $this->getTopServices($start_date, $end_date);

        $title = 'Financial Reports';
        $showNavbar = true;

        include dirname(__DIR__) . '/views/reports/financial.php';
    }

    // Appointment reports
    public function appointments()
    {
        $start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $end_date = $_GET['end_date'] ?? date('Y-m-d');

        $appointmentStats = $this->getAppointmentStatistics($start_date, $end_date);
        $doctorAppointments = $this->getDoctorAppointmentStats($start_date, $end_date);
        $appointmentTrends = $this->getAppointmentTrends($start_date, $end_date);

        $title = 'Appointment Reports';
        $showNavbar = true;

        include dirname(__DIR__) . '/views/reports/appointments.php';
    }

    // Medicine/pharmacy reports
    public function pharmacy()
    {
        $lowStock = $this->getLowStockMedicines();
        $expiringMedicines = $this->getExpiringMedicines();
        $medicineSales = $this->getMedicineSales();

        $title = 'Pharmacy Reports';
        $showNavbar = true;

        include dirname(__DIR__) . '/views/reports/pharmacy.php';
    }

    // Export report as PDF
    public function export($type = 'summary')
    {
        // Set headers for PDF download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="report_' . date('Y-m-d') . '.pdf"');

        // In a real app, you would generate PDF here
        // For now, we'll redirect to view
        $this->session->setFlash('info', 'PDF export feature coming soon!');
        header('Location: ' . BASE_URL . 'reports');
        exit();
    }

    // ============ HELPER METHODS ============

    private function getStatistics($start_date, $end_date)
    {
        return [
            'total_patients' => $this->countTable('patients', $start_date, $end_date),
            'total_appointments' => $this->countTable('appointments', $start_date, $end_date),
            'total_prescriptions' => $this->countTable('prescriptions', $start_date, $end_date),
            'total_revenue' => $this->getTotalRevenue($start_date, $end_date),
            'completed_appointments' => $this->countCompletedAppointments($start_date, $end_date),
            'new_patients' => $this->countNewPatients($start_date, $end_date)
        ];
    }

    private function getDailyStatistics($start_date, $end_date)
    {
        // First, get patient counts by date
        $stmt = $this->db->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as patients
        FROM patients
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY DATE(created_at)
        ORDER BY date
    ");
        $stmt->execute([$start_date, $end_date]);
        $patientStats = $stmt->fetchAll();

        // Now get appointment counts by date
        $stmt = $this->db->prepare("
        SELECT 
            DATE(appointment_date) as date,
            COUNT(*) as appointments
        FROM appointments
        WHERE DATE(appointment_date) BETWEEN ? AND ?
        GROUP BY DATE(appointment_date)
        ORDER BY date
    ");
        $stmt->execute([$start_date, $end_date]);
        $appointmentStats = $stmt->fetchAll();

        // Merge the results
        $result = [];

        // Create date range
        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1D'),
            new DateTime($end_date . ' +1 day')
        );

        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            $result[$dateStr] = [
                'date' => $dateStr,
                'patients' => 0,
                'appointments' => 0
            ];
        }

        // Fill in patient counts
        foreach ($patientStats as $stat) {
            $dateStr = $stat['date'];
            if (isset($result[$dateStr])) {
                $result[$dateStr]['patients'] = (int)$stat['patients'];
            }
        }

        // Fill in appointment counts
        foreach ($appointmentStats as $stat) {
            $dateStr = $stat['date'];
            if (isset($result[$dateStr])) {
                $result[$dateStr]['appointments'] = (int)$stat['appointments'];
            }
        }

        return array_values($result);
    }

    private function getTopDoctors($start_date, $end_date)
    {
        $stmt = $this->db->prepare("
        SELECT 
            u.id,
            CONCAT(u.first_name, ' ', u.last_name) as doctor_name,
            u.specialization,
            COUNT(a.id) as appointment_count,
            COALESCE((
                SELECT COUNT(*) 
                FROM prescriptions 
                WHERE doctor_id = u.id 
                AND DATE(prescription_date) BETWEEN ? AND ?
            ), 0) as prescription_count
        FROM users u
        LEFT JOIN appointments a ON u.id = a.doctor_id 
            AND DATE(a.appointment_date) BETWEEN ? AND ?
        WHERE u.role_id = ?
        GROUP BY u.id, u.first_name, u.last_name, u.specialization
        ORDER BY appointment_count DESC
        LIMIT 5
    ");
        $stmt->execute([$start_date, $end_date, $start_date, $end_date, ROLE_DOCTOR]);
        return $stmt->fetchAll();
    }

    private function getRevenueData($start_date, $end_date)
    {
        $stmt = $this->db->prepare("
            SELECT 
                DATE(billing_date) as date,
                COALESCE(SUM(total_amount), 0) as revenue
            FROM billing
            WHERE DATE(billing_date) BETWEEN ? AND ?
            GROUP BY DATE(billing_date)
            ORDER BY date
        ");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetchAll();
    }

    private function getPatientStatistics($start_date, $end_date)
    {
        $stmt = $this->db->prepare("
        SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN DATE(created_at) BETWEEN ? AND ? THEN 1 ELSE 0 END) as new_this_period,
            AVG(TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE())) as avg_age,
            SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) as male,
            SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) as female,
            SUM(CASE WHEN gender = 'Other' THEN 1 ELSE 0 END) as other
        FROM patients
    ");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetch();
    }

    private function getNewPatients($start_date, $end_date)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM patients 
            WHERE DATE(created_at) BETWEEN ? AND ?
            ORDER BY created_at DESC
            LIMIT 10
        ");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetchAll();
    }

    private function getRevenueStatistics($start_date, $end_date)
    {
        $stmt = $this->db->prepare("
            SELECT 
                COALESCE(SUM(total_amount), 0) as total_revenue,
                COALESCE(SUM(paid_amount), 0) as collected,
                COALESCE(SUM(total_amount - paid_amount), 0) as pending,
                COUNT(*) as total_bills,
                AVG(total_amount) as avg_bill_amount
            FROM billing
            WHERE DATE(billing_date) BETWEEN ? AND ?
        ");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetch();
    }

    private function getPaymentMethodStats($start_date, $end_date)
    {
        $stmt = $this->db->prepare("
            SELECT 
                payment_method,
                COUNT(*) as count,
                SUM(total_amount) as amount
            FROM billing
            WHERE DATE(billing_date) BETWEEN ? AND ?
            GROUP BY payment_method
        ");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetchAll();
    }

    private function getTopServices($start_date, $end_date)
    {
        $stmt = $this->db->prepare("
            SELECT 
                item_description,
                COUNT(*) as count,
                SUM(amount) as revenue
            FROM billing_items
            WHERE bill_id IN (SELECT id FROM billing WHERE DATE(billing_date) BETWEEN ? AND ?)
            GROUP BY item_description
            ORDER BY revenue DESC
            LIMIT 10
        ");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetchAll();
    }

    private function getAppointmentStatistics($start_date, $end_date)
    {
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled,
                SUM(CASE WHEN status = 'No Show' THEN 1 ELSE 0 END) as no_show,
                AVG(TIMESTAMPDIFF(MINUTE, appointment_time, ADDTIME(appointment_time, '01:00:00'))) as avg_duration
            FROM appointments
            WHERE appointment_date BETWEEN ? AND ?
        ");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetch();
    }

    private function getDoctorAppointmentStats($start_date, $end_date)
    {
        $stmt = $this->db->prepare("
        SELECT 
            CONCAT(u.first_name, ' ', u.last_name) as doctor_name,
            COUNT(a.id) as total_appointments,
            SUM(CASE WHEN a.status = 'Completed' THEN 1 ELSE 0 END) as completed
        FROM users u
        LEFT JOIN appointments a ON u.id = a.doctor_id 
            AND a.appointment_date BETWEEN ? AND ?
        WHERE u.role_id = ?
        GROUP BY u.id, u.first_name, u.last_name
        HAVING total_appointments > 0
        ORDER BY total_appointments DESC
    ");
        $stmt->execute([$start_date, $end_date, ROLE_DOCTOR]);
        return $stmt->fetchAll();
    }

    private function getAppointmentTrends($start_date, $end_date)
    {
        $stmt = $this->db->prepare("
        SELECT 
            DATE(appointment_date) as date,
            DAYNAME(appointment_date) as day,
            COUNT(*) as appointments
        FROM appointments
        WHERE appointment_date BETWEEN ? AND ?
        GROUP BY DATE(appointment_date)
        ORDER BY date
    ");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetchAll();
    }

    private function getLowStockMedicines()
    {
        $stmt = $this->db->query("
            SELECT * FROM medicines 
            WHERE stock_quantity <= reorder_level AND is_active = 1
            ORDER BY stock_quantity ASC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    private function getExpiringMedicines()
    {
        $stmt = $this->db->query("
            SELECT * FROM medicines 
            WHERE expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 90 DAY)
            AND is_active = 1
            ORDER BY expiry_date ASC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    private function getMedicineSales()
    {
        $stmt = $this->db->query("
            SELECT 
                m.name,
                m.medicine_code,
                SUM(pi.quantity) as total_quantity,
                SUM(pi.quantity * m.unit_price) as total_revenue
            FROM prescription_items pi
            JOIN medicines m ON pi.medicine_id = m.id
            JOIN prescriptions p ON pi.prescription_id = p.id
            WHERE p.status = 'Fulfilled'
            AND p.prescription_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            GROUP BY m.id
            ORDER BY total_revenue DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    private function countTable($table, $start_date, $end_date)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM $table WHERE DATE(created_at) BETWEEN ? AND ?");
        $stmt->execute([$start_date, $end_date]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }

    private function getTotalRevenue($start_date, $end_date)
    {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE DATE(billing_date) BETWEEN ? AND ?");
        $stmt->execute([$start_date, $end_date]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    private function countCompletedAppointments($start_date, $end_date)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM appointments WHERE status = 'Completed' AND appointment_date BETWEEN ? AND ?");
        $stmt->execute([$start_date, $end_date]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }

    private function countNewPatients($start_date, $end_date)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM patients WHERE DATE(created_at) BETWEEN ? AND ?");
        $stmt->execute([$start_date, $end_date]);
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }
}
