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
        $selectedSemester = $_GET['semester'] ?? (date('n') <= 6 ? '2' : '1');

        try {
            $topAchievements = Achievement::getTopAchievementsByYearAndSemester(
                $this->db,
                $selectedYear,
                $selectedSemester
            );

            View::render('dashboard', [
                'topAchievements' => $topAchievements,
                'selectedYear' => $selectedYear,
                'selectedSemester' => $selectedSemester
            ]);
        } catch (\PDOException $e) {
            // Handle error
            error_log($e->getMessage());
            View::render('dashboard', [
                'topAchievements' => [],
                'selectedYear' => $selectedYear,
                'selectedSemester' => $selectedSemester
            ]);
        }
    }
}