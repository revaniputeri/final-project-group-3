<?php

namespace PrestaC\Controllers;

use PDO;
use PrestaC\App\View;
use PrestaC\Models\Student;

class StudentController
{
    protected PDO $db;

    public function __construct(array $dependencies)
    {
        $this->db = $dependencies['db']->getConnection();
        $this->ensureSession();
    }

    private function ensureSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function viewProfile()
    {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }
        $profile = Student::getStudentById($this->db, $_SESSION['user']['id']);
        View::render('profileCustom-Student', ['profile' => $profile]);
    }
    
    public function editProfileProcess()
    {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }
    
        // Data dari form
        $data = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'bio' => $_POST['bio'] ?? ''
        ];

            // Proses upload file foto profil
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../public/uploads/profile_images/';
        $fileName = uniqid() . '-' . basename($_FILES['profile_image']['name']);
        $targetFile = $uploadDir . $fileName;

                // Validasi jenis file (opsional)
                $fileType = mime_content_type($_FILES['profile_image']['tmp_name']);
                if (in_array($fileType, ['image/jpeg', 'image/png', 'image/gif'])) {
                    // Pindahkan file ke folder upload
                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                        $data['profile_image'] = '/uploads/profile_images/' . $fileName;
                    } else {
                        $_SESSION['error_message'] = 'Gagal mengunggah foto profil.';
                        header('Location: /dashboard/profile-customization');
                        exit;
                    }
                } else {
                    $_SESSION['error_message'] = 'Format file tidak didukung.';
                    header('Location: /dashboard/profile-customization');
                    exit;
                }
            }
    
        // Update profil di database
        $success = Student::updateStudentProfile($this->db, $_SESSION['user']['id'], $data);
    
        // Feedback
        if ($success) {
            $_SESSION['success_message'] = 'Profil berhasil diperbarui!';
        } else {
            $_SESSION['error_message'] = 'Terjadi kesalahan saat memperbarui profil.';
        }
    
        header('Location: /dashboard/profile-customization');
        exit;
    }    
}