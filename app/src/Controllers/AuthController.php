<?php

namespace PrestaC\Controllers;

use PDO;
use PrestaC\App\View;

class AuthController
{
    protected PDO $db;
    function __construct(array $dependencies)
    {
        $this->db = $dependencies['db']->getConnection();
    }

    public function guest()
    {
        View::render('guest', '');
    }
    

    public function login()
    {
        View::render('login', '');
    }

    public function register()
    {
        View::render('register', '');
    }

    public function logout()
    {
        View::render('logout', '');
    }

    public function loginProcess($username, $password)
    {
        session_start();

        $row = $this->db->prepare('SELECT * FROM user WHERE username=:username');
        $row->execute([
            "username" => $username
        ]);
        $count = $row->rowCount();
        if ($count < 1) {
            $_SESSION['error_message'] = "Incorrect username or password";
            header('Location: /login');
            return;
        }

        $user = $row->fetch();
        if (!password_verify($password, $user['password'])) {
            $_SESSION['error_message'] = "Incorrect username or password";
            header('Location: /login');
            return;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'fullName' => $user['fullName']
        ];
        header('Location: /dashboard');
    }

    public function registerProcess($fullname, $username, $password, $email, $phone, $avatar, $role, $createdAt, $updatedAt, $deletedAt): void  
    {
        session_start();
        //check username
        $row = $this->db->prepare('SELECT * FROM user WHERE username=:username');
        $row->execute(params: [
            "username" => $username
        ]);

        //validasi
        $count = $row->rowCount();
        if ($count > 0) {
            $_SESSION['error_message'] = "Username already exists";
            header('Location: /register');
            return;
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        //insert new user
        $row = $this->db->prepare('INSERT INTO user (fullName, username, password, email, phone, avatar, role, createdAt, updatedAt, deletedAt) VALUES (:fullName, :username, :password, :email, :phone, :avatar, :role, :createdAt, :updatedAt, :deletedAt)');

        // intinya bindParam -> securely add data to db
        $row->bindParam(':fullName', $fullname);
        $row->bindParam(':username', $username);
        $row->bindParam(':password', $hashed_password); 
        $row->bindParam(':email', $email);
        $row->bindParam(':phone', $phone);
        $row->bindParam(':avatar', $avatar);
        $row->bindParam(':role', $role);
        $row->bindParam(':createdAt', $createdAt);
        $row->bindParam(':updatedAt', $updatedAt);
        $row->bindParam(':deletedAt', $deletedAt);

        $row->execute();
    }

    public function logoutProcess(): void
    {
        session_start();
        $_SESSION = array();
        session_destroy();

        header('Location: /guest');
        exit;
    }
}
