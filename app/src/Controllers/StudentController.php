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
    
        // Gunakan data dari sesi untuk mengisi profil
        $profile = [
            'name' => $_SESSION['user']['fullName'] ?? null,
            'nim' => $_SESSION['user']['username'] ?? null,
            'email' => $_SESSION['user']['email'] ?? null,
            'profile_image' => $_SESSION['user']['profile_image'] ?? null
        ];
    
        // Tampilkan halaman dengan data profil
        View::render('profileCustom-Student', ['profile' => $profile]);
    }    

    public function editProfileProcess(array $data)
    {
        // Validasi data input
        $name = $data['name'] ?? null;
        $nim = $data['nim'] ?? null;
        $email = $data['email'] ?? null;
        $angkatan = $data['jurusan'] ?? null;
        $profileImage = $_FILES['profile_image'] ?? null;

        if (!$name || !$nim || !$email || !$angkatan) {
            $_SESSION['error_message'] = 'Semua data wajib diisi!';
            header('Location: /dashboard/profile-customization');
            exit;
        }

        // Proses unggah file 
        $uploadedFilePath = null;
        if ($profileImage && $profileImage['error'] === UPLOAD_ERR_OK) {
            $uploadDir = dirname(__DIR__, 3) . '/public/uploads/'; 
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); 
            }

            $uploadedFilePath = $uploadDir . basename($profileImage['name']);
            if (!move_uploaded_file($profileImage['tmp_name'], $uploadedFilePath)) {
                $_SESSION['error_message'] = 'Gagal mengunggah file gambar.';
                header('Location: /dashboard/profile-customization');
                exit;
            }
        }

        // Update data di database
        $updateSuccess = Student::updateStudentProfile($this->db, $_SESSION['user']['id'], [
            'name' => $name,
            'nim' => $nim,
            'email' => $email,
            'angkatan' => $angkatan,
            'profile_image' => $uploadedFilePath,
        ]);

        if ($updateSuccess) {
            // Ambil data terbaru dari database
            $updatedProfile = Student::getStudentById($this->db, $_SESSION['user']['id']);

            // Perbarui data di session agar langsung terlihat
            $_SESSION['user'] = [
                'id' => $updatedProfile['id'],
                'name' => $updatedProfile['name'],
                'nim' => $updatedProfile['nim'],
                'email' => $updatedProfile['email'],
                'angkatan' => $updatedProfile['angkatan'],
                'profile_image' => $updatedProfile['profile_image'],
            ];

            $_SESSION['success_message'] = 'Profil berhasil diperbarui!';
        } else {
            $_SESSION['error_message'] = 'Terjadi kesalahan saat memperbarui profil.';
        }

        // Redirect kembali ke halaman profil
        header('Location: /dashboard/profile');
        exit;
    }
    public function updateProfileImage(array $data)
{
    $profileImage = $_FILES['profile_image'] ?? null;

    if ($profileImage && $profileImage['error'] === UPLOAD_ERR_OK) {
        $uploadDir = dirname(__DIR__, 3) . '/public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadedFilePath = $uploadDir . basename($profileImage['name']);
        if (move_uploaded_file($profileImage['tmp_name'], $uploadedFilePath)) {
            // Update database with new profile image path
            $updateSuccess = Student::updateStudentProfile($this->db, $_SESSION['user']['id'], [
                'profile_image' => $uploadedFilePath,
            ]);

            if ($updateSuccess) {
                // Update session data
                $_SESSION['user']['profile_image'] = $uploadedFilePath;
                $_SESSION['success_message'] = 'Foto profil berhasil diperbarui!';
            } else {
                $_SESSION['error_message'] = 'Terjadi kesalahan saat memperbarui foto profil.';
            }
        } else {
            $_SESSION['error_message'] = 'Gagal mengunggah file gambar.';
        }
    } else {
        $_SESSION['error_message'] = 'Tidak ada file yang diunggah atau terjadi kesalahan saat mengunggah.';
    }

    header('Location: /dashboard/profile');
    exit;
}

public function updateProfileBackground(array $data)
{
    $profileBackground = $_FILES['profile_background'] ?? null;

    if ($profileBackground && $profileBackground['error'] === UPLOAD_ERR_OK) {
        $uploadDir = dirname(__DIR__, 3) . '/public/uploads/backgrounds/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadedFilePath = $uploadDir . basename($profileBackground['name']);
        if (move_uploaded_file($profileBackground['tmp_name'], $uploadedFilePath)) {
            // Update database with new background image path
            $updateSuccess = Student::updateStudentProfile($this->db, $_SESSION['user']['id'], [
                'profile_background' => $uploadedFilePath,
            ]);

            if ($updateSuccess) {
                // Update session data
                $_SESSION['user']['profile_background'] = $uploadedFilePath;
                $_SESSION['success_message'] = 'Background profil berhasil diperbarui!';
            } else {
                $_SESSION['error_message'] = 'Terjadi kesalahan saat memperbarui background profil.';
            }
        } else {
            $_SESSION['error_message'] = 'Gagal mengunggah file gambar.';
        }
    } else {
        $_SESSION['error_message'] = 'Tidak ada file yang diunggah atau terjadi kesalahan saat mengunggah.';
    }

    header('Location: /dashboard/profile');
    exit;
}
}