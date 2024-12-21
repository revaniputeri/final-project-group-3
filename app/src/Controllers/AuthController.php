<?php

namespace PrestaC\Controllers;

use PDO;
use PrestaC\App\View;
use PrestaC\Models\User;

class AuthController
{
    //property buat nyimpen connectionnya
    protected PDO $db;

    //constructor buat nyimpen connectionnya
    function __construct(array $dependencies)
    {
        $this->db = $dependencies['db']->getConnection();
    }

    //method buat redirect ke dashboard/home kalo udah login
    public function redirect()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            header('Location: /dashboard/home');
            exit();
        } else {
            header('Location: /guest');
            exit();
        }
    }

    public function guest()
    {
        session_start();
        View::render('guest', []);
    }

    public function login()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            $role = $_SESSION['user']['role'];
            switch ($role) {
                case 1:
                    header('Location: /admin/dashboard');
                    break;
                case 2:
                    header('Location: /dashboard/home');
                    break;
                case 3:
                    header('Location: /dashboard/lecturer');
                    break;
                default:
                    header('Location: /guest');
            }
            return;
        }
        View::render('login', []);
    }

    public function loginProcess()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        session_start();

        // Validate username exists
        $user = User::findByUsername($this->db, $username);
        if (!$user) {
            $_SESSION['error'] = "Invalid username or password";
            header('Location: /login');
            return;
        }

        // Validate password
        $isPasswordCorrect = $user->validatePassword($password);
        if (!$isPasswordCorrect) {
            $_SESSION['error'] = "Invalid username or password";
            header('Location: /login');
            return;
        }

        // Login successful
        $_SESSION['user'] = [
            'id' => $user->id,
            'fullName' => $user->fullName,
            'username' => $user->username,
            'role' => (int)$user->role,
            'prodi' => ($user->fullName == 'Admin Program Studi Sistem Informasi Bisnis') ? 2 : 1
        ];

        switch ($_SESSION['user']['role']) {
            case 1: // Admin
                header('Location: /admin/dashboard');
                break;
            case 2: // Student
                header('Location: /dashboard/home');
                break;
            case 3: // Lecturer
                header('Location: /lecturer/dashboard');;
                break;
            default:
                header('Location: /guest');
                break;
        }
    }
    public function logout()
    {
        session_start();
        View::render('logout', []);
    }

    public function logoutProcess(): void
    {
        session_start();
        session_unset();
        session_destroy();
        
        header('Location: /guest');
        exit();
    }
}