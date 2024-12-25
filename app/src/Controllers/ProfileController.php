<?php

namespace PrestaC\Controllers;

use PDO;
use PrestaC\App\View;
use PrestaC\Models\Student;

class ProfileController
{
    protected PDO $db;

    function __construct(array $dependencies)
    {
        $this->db = $dependencies['db']->getConnection();
        $this->ensureSession(); // Initialize session for all controller methods
    }

    private function ensureSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Profile method for handling profile rendering
    public function viewProfile()
    {
        // Ensure session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in (ensure session has user data)
        if (!isset($_SESSION['user']['username'])) {
            header('Location: /login');
            exit;
        }

        // Get student data from the database using getStudentByUsername
        $profileData = Student::getStudentById($this->db, $_SESSION['user']['id']);

        // Default profile array if no data found
        $profile = [
            'name' => $_SESSION['user']['fullName'] ?? ($profileData['fullName'] ?? 'blom login banh'),
            'nim' => $_SESSION['user']['username'] ?? ($profileData['username'] ?? 'blom login banh'),
            'email' => $_SESSION['user']['email'] ?? ($profileData['email'] ?? 'blom login banh'),
            'phone' => $_SESSION['user']['phone'] ?? ($profileData['phone'] ?? 'blom login banh'),
            'studentMajor' => $profileData['StudentMajor'] ?? 'unknown',
            'studentStatus' => $profileData['StudentStatus'] ?? 'unknown',
            'points' => $profileData['CompetitionPoints'] ?? 'yahahah gada point',
            'prestasi' => $profileData['AchievementCount'] ?? 'yahahaha gadue prestasi'
        ];

        // Render the profile view with the profile data
        View::render('profileEdit', ['profile' => $profile]);
    }
}