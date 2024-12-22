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

    public function viewProfile()
    {   
        // Check if the session is already started before calling session_start()
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        View::render('profileEdit', []);
    }

    // Profile method for handling profile rendering
    public function profile()
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

        // Get username from session
        $username = $_SESSION['user']['username'];

        // Get student data from the database using getStudentByUsername
        $profileData = Student::getStudentByUsername($this->db, $username);

        // Default profile array if no data found
        $profile = [
            'name' => $_SESSION['user']['fullName'] ?? ($profileData['fullName'] ?? 'Nama tidak ditemukan'),
            'nim' => $_SESSION['user']['username'] ?? ($profileData['username'] ?? 'NIM tidak ditemukan'),
            'email' => $_SESSION['user']['email'] ?? ($profileData['email'] ?? ''),
            'profile_image' => $_SESSION['user']['profile_image'] ?? ($profileData['profile_image'] ?? '/path/to/default-image.jpg'),
        ];

        // Render the profile view with the profile data
        View::render('profileEdit', ['profile' => $profile]);
    }
    public function editProfile()
    {
        // Pastikan sesi dimulai
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Periksa apakah pengguna sudah login
        if (!isset($_SESSION['user']['username'])) {
            header('Location: /login');
            exit;
        }

        // Ambil data dari request POST
        $email = $_POST['email'] ?? '';
        $jurusan = $_POST['jurusan'] ?? '';

        // Validasi input (contoh validasi sederhana)
        if (empty($email) || empty($jurusan)) {
            $_SESSION['flash'] = 'Email dan jurusan tidak boleh kosong!';
            header('Location: /profileEdit/');
            exit;
        }

        // Ambil username dari sesi
        $username = $_SESSION['user']['username'];

        // Simpan ke database
        $updateStatus = Student::updateStudentProfile($this->db, $username, [
            'email' => $email,
            'jurusan' => $jurusan,
        ]);

        // Periksa apakah penyimpanan berhasil
        if ($updateStatus) {
            $_SESSION['flash'] = 'Profil berhasil diperbarui.';
        } else {
            $_SESSION['flash'] = 'Terjadi kesalahan saat memperbarui profil.';
        }

        // Redirect kembali ke halaman edit profil
        header('Location: /profileEdit/');
        exit;
    }
}