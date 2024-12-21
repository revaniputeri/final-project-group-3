<?php

namespace PrestaC\Controllers;

use PDO;
use PrestaC\App\View;
use PrestaC\Models\Student;
use PrestaC\Models\User;

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

    // public function profile()
    // {
    //     $fullName = $_POST['fullName'];
    //     $username = $_POST['username'];
        
    //     session_start();

    //     // Validate username exists
    //     $user = User::getStudentFullName($this->db, $username);
    //     $user = User::getStudentByUsername($this->db, $username);
    //     // Login successful

    //     $_SESSION['user'] = [
    //         'id' => $user->id,
    //         'fullName' => $user->fullName,
    //         'role' => (int)$user->role,
    //         'prodi' => ($user->fullName == 'Admin Program Studi Sistem Informasi Bisnis') ? 2 : 1
    //     ];
    // }
}