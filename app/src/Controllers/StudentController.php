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
}