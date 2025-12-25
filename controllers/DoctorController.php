<?php
// medico/controllers/DoctorController.php

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/includes/Auth.php';
require_once dirname(__DIR__) . '/includes/Session.php';
require_once dirname(__DIR__) . '/config/Database.php';

class DoctorController
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
            $this->session->setFlash('error', 'Please login first.');
            header('Location: ' . BASE_URL . 'index.php?url=auth/login');
            exit();
        }

        // Verify user is a doctor
        if ($this->session->get('role') != ROLE_DOCTOR) {
            $this->session->setFlash('error', 'Access denied. Doctor role required.');
            header('Location: ' . BASE_URL . 'index.php?url=dashboard');
            exit();
        }
    }

    public function index()
    {
        // Redirect to doctor dashboard
        header('Location: ' . BASE_URL . 'dashboard');
        exit();
    }

    public function schedule()
    {
        // Only doctors can access
        if ($this->session->get('role') != ROLE_DOCTOR) {
            $this->session->setFlash('error', 'Access denied.');
            header('Location: ' . BASE_URL . 'index.php?url=dashboard');
            exit();
        }

        $doctor_id = $this->session->get('user_id');

        // Get schedule for the current week
        $schedule = $this->getWeeklySchedule($doctor_id);

        $title = 'Doctor Schedule';
        $showNavbar = true;

        extract([
            'schedule' => $schedule,
            'title' => $title,
            'showNavbar' => $showNavbar
        ]);

        ob_start();
        include dirname(__DIR__) . '/views/doctor/schedule.php';
        $content = ob_get_clean();
        include dirname(__DIR__) . '/views/layouts/main.php';
    }

    public function patients()
    {
        $doctor_id = $this->session->get('user_id');

        // Get all patients
        $patients = $this->getAllDoctorPatients($doctor_id);

        $title = 'Patient List';
        $showNavbar = true;

        extract([
            'patients' => $patients,
            'title' => $title,
            'showNavbar' => $showNavbar
        ]);

        ob_start();
        include dirname(__DIR__) . '/views/doctor/patients.php';
        $content = ob_get_clean();
        include dirname(__DIR__) . '/views/layouts/main.php';
    }

    // Add other doctor-specific methods here
    public function appointments()
    {
        // Doctor's appointment management
    }

    public function prescriptions()
    {
        // Doctor's prescription management
    }

    // Private helper methods
    private function getWeeklySchedule($doctor_id)
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
                AND a.appointment_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                AND a.status != 'Cancelled'
                ORDER BY a.appointment_date ASC, a.appointment_time ASC
            ");
            $stmt->execute([$doctor_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error in getWeeklySchedule: " . $e->getMessage());
            return [];
        }
    }

    private function getAllDoctorPatients($doctor_id)
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
                ORDER BY p.last_name ASC, p.first_name ASC
            ");
            $stmt->execute([$doctor_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error in getAllDoctorPatients: " . $e->getMessage());
            return [];
        }
    }
}
