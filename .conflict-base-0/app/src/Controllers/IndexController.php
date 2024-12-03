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
        View::render('dashboard', []);
    }

    public function getTopAchievements()
    {
        $this->ensureSession();

        // Get filter parameters
        $selectedYear = $_GET['tahun'] ?? date('Y');

        try {
            $topAchievements = Achievement::getTopAchievementsByYear(
                $this->db,
                $selectedYear,
                $_SESSION['user']['id']
            );

            View::render('dashboard', [
                'topAchievements' => $topAchievements,
                'selectedYear' => $selectedYear
            ]);
        } catch (\PDOException $e) {
            // Handle error
            error_log($e->getMessage());
            View::render('dashboard', [
                'topAchievements' => [],
                'selectedYear' => $selectedYear
            ]);
        }
    }
}