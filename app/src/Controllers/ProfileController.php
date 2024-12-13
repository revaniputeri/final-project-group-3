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

    // Create a new profile
    public function createProfile()
    {
        session_start();

        // Retrieve input data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $bio = $_POST['bio'];
        $profilePicture = $_FILES['profilePicture']['tmp_name'] ?? null;

        try {
            // Insert new profile data in each model as applicable
            $studentId = Student::createStudent($this->db, [
                'username' => $username,
                'email' => $email,
                'bio' => $bio,
                'profilePicture' => $profilePicture
            ]);

            $dosenId = Dosen::createDosen($this->db, [
                'username' => $username,
                'email' => $email,
                'bio' => $bio,
                'profilePicture' => $profilePicture
            ]);

            $adminId = Admin::createAdmin($this->db, [
                'username' => $username,
                'email' => $email,
                'bio' => $bio,
                'profilePicture' => $profilePicture
            ]);

            $_SESSION['success'] = "Profil berhasil dibuat.";
            header('Location: /dashboard/profile/view/' . $studentId); // Redirect ke halaman profil
            exit();

        } catch (\Exception $e) {
            $_SESSION['error'] = "Terjadi kesalahan saat membuat profil: " . $e->getMessage();
            header('Location: /dashboard/profile/create');
            exit();
        }
    }

    // View profile page (Read)
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
            $_SESSION['error'] = "Terjadi kesalahan saat mengambil data profil.";
            header('Location: /dashboard/home');
            exit();
        }
    }

    // Display profile edit form (for Update)
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
            $_SESSION['error'] = "Terjadi kesalahan saat mengambil data profil untuk diedit.";
            header('Location: /dashboard/profile');
            exit();
        }
    }

    // Process profile update (Update)
    public function editProfileProcess()
    {
        session_start();
        $userId = $_SESSION['user']['id'];
        
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

            $_SESSION['success'] = "Profil berhasil diperbarui.";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Gagal memperbarui profil: " . $e->getMessage();
        }

        header('Location: /dashboard/profile');
        exit();
    }

    // Delete a profile (Delete)
    public function deleteProfile()
    {
        session_start();
        $userId = $_SESSION['user']['id'];

        try {
            // Soft delete profile from each model as applicable
            Student::deleteStudent($this->db, $userId);
            Dosen::deleteDosen($this->db, $userId);
            Admin::deleteAdmin($this->db, $userId);

            $_SESSION['success'] = "Profil berhasil dihapus.";
            header('Location: /dashboard');
            exit();

        } catch (\Exception $e) {
            $_SESSION['error'] = "Terjadi kesalahan saat menghapus profil.";
            header('Location: /dashboard/profile');
            exit();
        }
    }
}