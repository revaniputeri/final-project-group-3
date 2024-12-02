<?php

namespace PrestaC\Controllers;

use PDO;
use PrestaC\App\View;
use PrestaC\Models\Achievement;

class IndexController 
{
    protected PDO $db;

    function __construct(array $dependencies)
    {
        $this->db = $dependencies['db']->getConnection();
    }

    private function ensureSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function dashboard()
    {
        $this->ensureSession();
        View::render('dashboard', []);
    }

    // public function getDataTableAchievements()
    // {
    //     $this->ensureSession();
    //     $topAchievements = Achievement::g
    // }
}