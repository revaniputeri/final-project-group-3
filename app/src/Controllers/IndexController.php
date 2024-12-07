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
        $this->ensureSession(); // Initialize session for all controller methods
    }

    private function ensureSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function dashboardAdmin()
{
    // Fetch the counts of accepted and rejected students
    $acceptedCount = Achievement::getAcceptedCount($this->db);
    $rejectedCount = Achievement::getRejectedCount($this->db);
    
    // Fetch top achievements if needed
    $topAchievements = Achievement::getTopAchievements($this->db, 10);

    View::render('dashboard-admin', [
        'acceptedCount' => $acceptedCount,
        'rejectedCount' => $rejectedCount,
        'topAchievements' => $topAchievements
        ]);
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

    public function info()
    {
        // Check if the session is already started before calling session_start()
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        View::render('achievement-informasi', []);
    }
}