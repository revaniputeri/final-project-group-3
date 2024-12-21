<?php

namespace PrestaC\Middleware;

class AuthMiddleware {
    //method buat ngecek apakah user sudah login atau belum, kalo belum, redirect ke login
    public function before(): void {
        session_start();
        if (!isset($_SESSION['user'])) {
            header(header: 'Location: /login');
            exit();
        }
    }
} 