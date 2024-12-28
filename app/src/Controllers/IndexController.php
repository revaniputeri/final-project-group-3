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

    private function validateUser()
    {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function dashboardAdmin()
    {
        //each prodi
        $acceptedCount = Achievement::getAcceptedCount($this->db, $_SESSION['user']['prodi']);
        $rejectedCount = Achievement::getRejectedCount($this->db, $_SESSION['user']['prodi']);
        $pendingCount = Achievement::getPendingCount($this->db, $_SESSION['user']['prodi']);
        $totalOfAchievementsByProdi = Achievement::getTotalOfAchievementsByProdi($this->db, $_SESSION['user']['prodi']);

        //pusat
        $acceptedCountPusat = Achievement::getAcceptedCountPusat($this->db);
        $rejectedCountPusat = Achievement::getRejectedCountPusat($this->db);
        $pendingCountPusat = Achievement::getPendingCountPusat($this->db);
        $totalOfAchievementsPusat = Achievement::getTotalOfAchievementsPusat($this->db);

        $topAchievements = Achievement::getTopAchievements($this->db, 10);

        View::render('dashboard-admin', [
            //render each prodi
            'acceptedCount' => $acceptedCount,
            'rejectedCount' => $rejectedCount,
            'pendingCount' => $pendingCount,
            'totalOfAchievementsByProdi' => $totalOfAchievementsByProdi,
            //render pusat
            'acceptedCountPusat' => $acceptedCountPusat,
            'rejectedCountPusat' => $rejectedCountPusat,
            'pendingCountPusat' => $pendingCountPusat,
            'totalOfAchievementsPusat' => $totalOfAchievementsPusat,
            //render top achievement
            'topAchievements' => $topAchievements
        ]);
    }

    public function getDataTableAchievements()
    {
        $this->ensureSession();
        $this->validateUser();

        $topAchievements = Achievement::getTopAchievements($this->db, 10, $_SESSION['user']['id']);
        $statusCount = [
            'PROSES' => Achievement::getAchievementCountByStatus($this->db, 'PROSES', $_SESSION['user']['id']),
            'DITERIMA' => Achievement::getAchievementCountByStatus($this->db, 'DITERIMA', $_SESSION['user']['id']),
            'DITOLAK' => Achievement::getAchievementCountByStatus($this->db, 'DITOLAK', $_SESSION['user']['id'])
        ];

        foreach ($topAchievements as &$achievement) {
            $achievement['CompetitionRankName'] = Achievement::getCompetitionRankName((int)$achievement['CompetitionRank']) ?? 'Unknown';
            $achievement['CompetitionLevelName'] = Achievement::getCompetitionLevelName((int)$achievement['CompetitionLevel']) ?? 'Unknown';
        }

        View::render('dashboard', [
            'topAchievements' => $topAchievements,
            'statusCount' => $statusCount
        ]);
    }

    public function getStudentAchievementCount()
    {
        $this->validateUser();

        $userId = $_SESSION['user']['id'];
        $achievements = Achievement::getAchievementsByUserId($this->db, $userId);

        $totalAchievements = count($achievements);
        $approvedCount = 0;
        $pendingCount = 0;
        $rejectedCount = 0;

        foreach ($achievements as $achievement) {
            switch ($achievement['AdminValidationStatus']) {
                case 'DITERIMA':
                    $approvedCount++;
                    break;
                case 'PROSES':
                    $pendingCount++;
                    break;
                case 'DITOLAK':
                    $rejectedCount++;
                    break;
            }
        }

        return [
            'totalAchievements' => $totalAchievements,
            'approvedCount' => $approvedCount,
            'pendingCount' => $pendingCount,
            'rejectedCount' => $rejectedCount
        ];
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
