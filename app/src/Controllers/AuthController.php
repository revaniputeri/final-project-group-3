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

    public function prosesLogin($username, $password)
    {
        session_start();

        $row = $this->db->prepare('SELECT * FROM tbl_user WHERE username=:username');
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
            'name' => $user['name'],
        ];
        header('Location: /dashboard');
    }

    public function prosesRegister($username, $name, $email, $password): void
    {
        session_start();
        //check username
        $row = $this->db->prepare('SELECT * FROM tbl_user WHERE username=:username');
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
        $row = $this->db->prepare('INSERT INTO tbl_user (username, name, email, password) VALUES (:username, :name, :email, :password)');

        // intinya bindParam -> securely add data to db
        $row->bindParam(':username', $username);
        $row->bindParam(':name', $name);
        $row->bindParam(':email', $email);
        $row->bindParam(':password', $hashed_password); 

        $row->execute();
    }

    public function prosesLogout(): void
    {
        session_start();
        $_SESSION = array();
        session_destroy();

        header('Location: /guest');
        exit;
    }
}
