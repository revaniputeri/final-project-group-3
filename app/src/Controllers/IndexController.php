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

    public function dashboardAdmin()
    {
        View::render('dashboard-admin', []);
    }

    public function dashboardLecturer()
    {
        View::render('dashboard-lecturer', []);
    }

    public function getDataTableAchievements()
    {
        $this->ensureSession();
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }

        $topAchievements = Achievement::getTopAchievements($this->db, 10, $_SESSION['user']['id']);
        View::render('dashboard', [
            'topAchievements' => $topAchievements
        ]);
    }
}