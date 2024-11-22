<?php

namespace PrestaC\Controllers;

use DateTime;
use PDO;
use PrestaC\App\View;
use PrestaC\Models\User;

class AuthController
{
    protected PDO $db;

    function __construct(array $dependencies)
    {
        $this->db = $dependencies['db']->getConnection();
    }

    public function redirect()
    {
        // check if a user has logged in, if they are then redirect to dashboard
        session_start();
        if (isset($_SESSION['user'])) {
            header('Location: /dashboard');
        } else {
            header('Location: /guest');
        }
    }

    public function guest()
    {
        View::render('guest', []);
    }


    public function login()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            header('Location: /dashboard');
            return;
        }
        View::render('login', []);
    }

    public function register()
    {
        View::render('register', []);
    }

    public function logout()
    {
        View::render('logout', []);
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
            'fullName' => $user->fullName
        ];
        header('Location: /dashboard');
    }

    public function registerProcess(): void
    {
        $fullname = $_POST['username'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $avatar = $_POST['avatar'];
        $role = $_POST['role'];

        session_start();
        //check if username already exists
        if (User::findByUsername($this->db, $username)) {
            $_SESSION['error_message'] = "Username already exists";
            header('Location: /register');
            exit;
        }

        User::register(
            $this->db,
            $fullname,
            $username,
            $password,
            $email,
            $phone,
            $avatar,
            $role
        );

        header('Location: /login');
    }

    public function logoutProcess(): void
    {
        session_start();
        $_SESSION = array();
        session_destroy();

        header('Location: /guest');
        return;
    }
}
