<?php

namespace PrestaC\Controllers;

use PDO;
use PrestaC\App\View;
use PrestaC\Models\Student;
use PrestaC\Models\Dosen;
use PrestaC\Models\Admin;

class ProfileController
{
    protected PDO $db;

    function __construct(array $dependencies)
    {
        $this->db = $dependencies['db']->getConnection();
    }

    // View profile page
    public function viewProfile()
    {
        session_start();
        $userId = $_SESSION['user']['id'];

        try {
            // Fetch data from multiple models
            $student = Student::getStudentById($this->db, $userId);
            $dosen = Dosen::getDosenById($this->db, $userId);
            $admin = Admin::getAdminById($this->db, $userId);

            View::render('profile/view', [
                'student' => $student,
                'dosen' => $dosen,
                'admin' => $admin
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = "An error occurred while fetching profile data.";
            header('Location: /dashboard/home');
            exit();
        }
    }

    // Display profile edit form
    public function editProfileForm()
    {
        session_start();
        $userId = $_SESSION['user']['id'];

        try {
            // Fetch user data for editing from different models
            $student = Student::getStudentById($this->db, $userId);
            $dosen = Dosen::getDosenById($this->db, $userId);
            $admin = Admin::getAdminById($this->db, $userId);

            View::render('profile/edit', [
                'student' => $student,
                'dosen' => $dosen,
                'admin' => $admin
            ]);
        } catch (\Exception $e) {
            $_SESSION['error'] = "An error occurred while fetching profile data for editing.";
            header('Location: /dashboard/profile');
            exit();
        }
    }

    // Process profile update
    public function editProfileProcess()
    {
        session_start();
        $userId = $_SESSION['user']['id'];
        
        // Retrieve and sanitize input data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $bio = $_POST['bio'];
        $profilePicture = $_FILES['profilePicture']['tmp_name'] ?? null;

        try {
            // Update profile for each model as applicable
            Student::updateStudentProfile($this->db, $userId, [
                'username' => $username,
                'email' => $email,
                'bio' => $bio,
                'profilePicture' => $profilePicture
            ]);
            
            Dosen::updateDosenProfile($this->db, $userId, [
                'username' => $username,
                'email' => $email,
                'bio' => $bio,
                'profilePicture' => $profilePicture
            ]);
            
            Admin::updateAdminProfile($this->db, $userId, [
                'username' => $username,
                'email' => $email,
                'bio' => $bio,
                'profilePicture' => $profilePicture
            ]);

            $_SESSION['success'] = "Profile updated successfully.";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Failed to update profile: " . $e->getMessage();
        }

        header('Location: /dashboard/profile');
        exit();
    }
}