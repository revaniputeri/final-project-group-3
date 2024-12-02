<?php

namespace PrestaC\Middleware;

class AuthMiddleware {
    public function before(): void {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    }
} 