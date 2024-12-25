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
        // Mulai sesi jika belum berjalan
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Pastikan user telah login
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit();
        }

        // Ambil ID user dari sesi
        $userId = $_SESSION['user']['id'];

        // Ambil data student dari database
        $student = Student::getStudentById($this->db, $userId);

        // Jika data tidak ditemukan, arahkan ke halaman error
        if (!$student) {
            header('Location: /error');
            exit();
        }

        // Tampilkan view dan kirimkan data student
        View::render('profileEdit', ['student' => $student]);
    }

}