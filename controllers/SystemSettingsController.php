<?php
// controllers/SystemSettingsController.php

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/includes/Auth.php';
require_once dirname(__DIR__) . '/includes/Session.php';
require_once dirname(__DIR__) . '/config/Database.php';

class SystemSettingsController
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

        // Only Super Admin can access system settings
        if ($this->session->get('role') != ROLE_SUPER_ADMIN) {
            $this->session->setFlash('error', 'Access denied. Only Super Administrators can access system settings.');
            header('Location: ' . BASE_URL . 'dashboard');
            exit();
        }
    }

    // Main settings dashboard
    public function index()
    {
        $title = 'System Settings';
        $showNavbar = true;
        
        // Create backup directory if it doesn't exist
        $backupDir = dirname(__DIR__) . '/backups/';
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        
        // Get database info
        $databaseInfo = $this->getDatabaseInfo();
        
        // Get system info
        $systemInfo = [
            'php_version' => phpversion(),
            'mysql_version' => $this->db->getAttribute(PDO::ATTR_SERVER_VERSION),
            'server_software' => $_SERVER['SERVER_SOFTWARE'],
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'max_execution_time' => ini_get('max_execution_time'),
        ];
        $systemStatus = $this->getSystemStatus();

        include dirname(__DIR__) . '/views/system-settings/index.php';
    }

    // General settings
    public function general()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveSettings($_POST, 'general');
            $this->session->setFlash('success', 'General settings updated successfully.');
            header('Location: ' . BASE_URL . 'system-settings/general');
            exit();
        }

        $title = 'General Settings';
        $showNavbar = true;

        // Get current settings (in real app, from database)
        $settings = $this->getDefaultSettings();
        
        include dirname(__DIR__) . '/views/system-settings/general.php';
    }

    // Email settings
    public function email()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveSettings($_POST, 'email');
            $this->session->setFlash('success', 'Email settings updated successfully.');
            header('Location: ' . BASE_URL . 'system-settings/email');
            exit();
        }

        $title = 'Email Settings';
        $showNavbar = true;
        
        $settings = $this->getDefaultEmailSettings();
        
        include dirname(__DIR__) . '/views/system-settings/email.php';
    }

    // Backup settings
    public function backup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['create_backup'])) {
                $this->createDatabaseBackup();
            } elseif (isset($_POST['clear_cache'])) {
                $this->clearCache();
            }
        }

        $title = 'Backup & Maintenance';
        $showNavbar = true;
        
        $backupInfo = $this->getBackupInfo();
        $systemStatus = $this->getSystemStatus();
        
        include dirname(__DIR__) . '/views/system-settings/backup.php';
    }

    // User management settings
    public function usersettings()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveSettings($_POST, 'user_management');
            $this->session->setFlash('success', 'User management settings updated successfully.');
            header('Location: ' . BASE_URL . 'system-settings/usersettings');
            exit();
        }

        $title = 'User Management Settings';
        $showNavbar = true;
        
        $settings = $this->getDefaultUserSettings();
        
        include dirname(__DIR__) . '/views/system-settings/usersettings.php';
    }

    // Clinic settings
    public function clinic()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveSettings($_POST, 'clinic');
            $this->session->setFlash('success', 'Clinic settings updated successfully.');
            header('Location: ' . BASE_URL . 'system-settings/clinic');
            exit();
        }

        $title = 'Clinic Settings';
        $showNavbar = true;
        
        $settings = $this->getDefaultClinicSettings();
        
        include dirname(__DIR__) . '/views/system-settings/clinic.php';
    }

    // ============ HELPER METHODS ============

    private function getDatabaseInfo()
    {
        $stmt = $this->db->query("
            SELECT 
                table_schema as database_name,
                ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size_mb,
                COUNT(*) as table_count
            FROM information_schema.tables 
            WHERE table_schema = DATABASE()
            GROUP BY table_schema
        ");
        return $stmt->fetch();
    }

    private function getBackupInfo()
    {
        $backupDir = dirname(__DIR__) . '/backups/';
        $backupFiles = [];
        $totalSize = 0;
        
        if (file_exists($backupDir)) {
            $files = scandir($backupDir);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $filePath = $backupDir . $file;
                    $backupFiles[] = [
                        'name' => $file,
                        'size' => filesize($filePath),
                        'modified' => date('Y-m-d H:i:s', filemtime($filePath))
                    ];
                    $totalSize += filesize($filePath);
                }
            }
        }
        
        return [
            'backup_files' => $backupFiles,
            'total_size' => $totalSize,
            'backup_dir' => $backupDir
        ];
    }

    private function getSystemStatus()
    {
        // Check disk space
        $diskTotal = disk_total_space(__DIR__);
        $diskFree = disk_free_space(__DIR__);
        $diskUsed = $diskTotal - $diskFree;
        $diskPercent = ($diskUsed / $diskTotal) * 100;
        
        // Check PHP memory
        $memoryLimit = ini_get('memory_limit');
        $memoryUsage = memory_get_usage(true);
        $memoryPeak = memory_get_peak_usage(true);
        
        return [
            'disk_total' => $diskTotal,
            'disk_free' => $diskFree,
            'disk_used' => $diskUsed,
            'disk_percent' => $diskPercent,
            'memory_limit' => $memoryLimit,
            'memory_usage' => $memoryUsage,
            'memory_peak' => $memoryPeak
        ];
    }

    private function createDatabaseBackup()
    {
        $backupDir = dirname(__DIR__) . '/backups/';
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        
        $backupFile = $backupDir . 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        
        // Get all tables
        $tables = [];
        $stmt = $this->db->query("SHOW TABLES");
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }
        
        // Create backup file
        $output = "-- Medico System Database Backup\n";
        $output .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $output .= "-- PHP Version: " . phpversion() . "\n";
        $output .= "-- MySQL Version: " . $this->db->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n\n";
        
        foreach ($tables as $table) {
            // Drop table if exists
            $output .= "DROP TABLE IF EXISTS `$table`;\n\n";
            
            // Create table structure
            $stmt = $this->db->query("SHOW CREATE TABLE `$table`");
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $output .= $row[1] . ";\n\n";
            
            // Insert data
            $stmt = $this->db->query("SELECT * FROM `$table`");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($rows) > 0) {
                $output .= "INSERT INTO `$table` VALUES \n";
                $insertValues = [];
                foreach ($rows as $row) {
                    $values = array_map(function($value) {
                        if ($value === null) return 'NULL';
                        return "'" . addslashes($value) . "'";
                    }, array_values($row));
                    $insertValues[] = "(" . implode(', ', $values) . ")";
                }
                $output .= implode(",\n", $insertValues) . ";\n\n";
            }
        }
        
        if (file_put_contents($backupFile, $output)) {
            $this->session->setFlash('success', 'Database backup created successfully.');
        } else {
            $this->session->setFlash('error', 'Failed to create backup.');
        }
    }

    private function clearCache()
    {
        // Clear session data (except current session)
        $currentSessionId = session_id();
        $sessionFiles = glob(session_save_path() . '/sess_*');
        
        foreach ($sessionFiles as $file) {
            if (basename($file) != 'sess_' . $currentSessionId) {
                @unlink($file);
            }
        }
        
        // Clear temporary files
        $tempDir = dirname(__DIR__) . '/tmp/';
        if (file_exists($tempDir)) {
            $files = glob($tempDir . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
        
        $this->session->setFlash('success', 'Cache cleared successfully.');
    }

    private function saveSettings($data, $category)
    {
        // In a real application, you would save to database
        // For now, we'll just simulate saving
        $_SESSION['system_settings'][$category] = $data;
    }

    private function getDefaultSettings()
    {
        return [
            'site_name' => 'Medico System',
            'site_title' => 'Hospital Management System',
            'timezone' => 'UTC',
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i',
            'items_per_page' => '20',
            'enable_registration' => '0',
            'maintenance_mode' => '0',
            'default_language' => 'en'
        ];
    }

    private function getDefaultEmailSettings()
    {
        return [
            'smtp_host' => '',
            'smtp_port' => '587',
            'smtp_username' => '',
            'smtp_password' => '',
            'smtp_encryption' => 'tls',
            'from_email' => 'noreply@medico.com',
            'from_name' => 'Medico System',
            'email_notifications' => '1'
        ];
    }

    private function getDefaultUserSettings()
    {
        return [
            'password_expiry_days' => '90',
            'max_login_attempts' => '5',
            'lockout_duration' => '15',
            'session_timeout' => '30',
            'require_2fa' => '0',
            'allow_multiple_sessions' => '1'
        ];
    }

    private function getDefaultClinicSettings()
    {
        return [
            'clinic_name' => 'Medico Clinic',
            'clinic_address' => '',
            'clinic_phone' => '',
            'clinic_email' => '',
            'clinic_website' => '',
            'working_hours' => '9:00 AM - 5:00 PM',
            'appointment_duration' => '30',
            'max_appointments_per_day' => '50'
        ];
    }
}
?>