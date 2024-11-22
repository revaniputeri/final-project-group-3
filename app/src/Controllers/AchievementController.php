<?php

namespace PrestaC\Controllers;

use PDO;
use PrestaC\App\View;
use PrestaC\Models\Achievement;
use PrestaC\Models\User;

class AchievementController
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

    public function index()
    {
        $this->ensureSession();
        View::render('achievements', []);
    }

    public function submissionForm()
    {
        $data = [
            'lecturers' => User::getAllActiveLecturers($this->db),
            'students' => User::getAllActiveStudents($this->db),
            'competitionLevels' => Achievement::getCompetitionLevels(),
            'competitionRanks' => Achievement::getCompetitionRanks()
        ];

         View::render('achievement-submission', $data);
    }

    public function submissionFormProcess()
    {
        $this->ensureSession();
        
        try {
            $userId = $_SESSION['user']['id'];
            $competitionType = $_POST['competitionType'];
            $competitionLevel = (int)$_POST['competitionLevel'];
            $competitionRank = (int)$_POST['competitionRank'];
            $competitionTitle = $_POST['competitionTitle'];
            $competitionTitleEnglish = $_POST['competitionTitleEnglish'];
            $competitionPlace = $_POST['competitionPlace'];
            $competitionPlaceEnglish = $_POST['competitionPlaceEnglish'];
            $competitionUrl = $_POST['competitionUrl'];
            $competitionStartDate = new \DateTime($_POST['competitionStartDate']);
            $competitionEndDate = new \DateTime($_POST['competitionEndDate']);
            $numberOfInstitutions = $_POST['numberOfInstitutions'];
            $numberOfStudents = $_POST['numberOfStudents'];
            $letterNumber = $_POST['letterNumber'];
            $letterDate = new \DateTime($_POST['letterDate']);
            $letterFile = $_FILES['letterFile'];
            $certificateFile = $_FILES['certificateFile'];
            $documentationFile = $_FILES['documentationFile'];
            $posterFile = $_FILES['posterFile'];

            // Calculate points based on competition level and rank
            $competitionPoints = $competitionLevel + $competitionRank;

            // Process supervisors
            $supervisors = [];
            if (isset($_POST['supervisors']) && is_array($_POST['supervisors'])) {
                foreach ($_POST['supervisors'] as $index => $supervisorId) {
                    if (!empty($supervisorId)) {
                        $supervisors[] = (int)$supervisorId;
                    }
                }
            }

            // Process team members
            $teamMembers = [];
            if (isset($_POST['teamMembers']) && is_array($_POST['teamMembers'])) {
                foreach ($_POST['teamMembers'] as $index => $memberId) {
                    if (!empty($memberId)) {
                        $teamMembers[] = [
                            'userId' => (int)$memberId,
                            'role' => $_POST['teamMemberRoles'][$index] ?? 'Anggota'
                        ];
                    }
                }
            }

            $achievement = new Achievement(
                $userId,
                $competitionType,
                $competitionLevel,
                $competitionTitle,
                $competitionTitleEnglish,
                $competitionPlace,
                $competitionPlaceEnglish,
                $competitionUrl,
                $competitionStartDate,
                $competitionEndDate,
                $competitionRank,
                $numberOfInstitutions,
                $numberOfStudents,
                $letterNumber,
                $letterDate,
                $letterFile,
                $certificateFile,
                $documentationFile,
                $posterFile,
                $competitionPoints,
                new \DateTime(),
                new \DateTime(),
                null,
                'PENDING',
                null,
                null,
                'PENDING',
                null,
                null
            );

            // Pass supervisors and team members to saveAchievement
            $achievementId = $achievement->saveAchievement($this->db, $supervisors, $teamMembers);
            $_SESSION['success'] = "Achievement saved successfully with ID: " . $achievementId;
            
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        if (isset($_SESSION['error'])) {
            header('Location: /dashboard/achievement/form');
        } else {
            header('Location: /dashboard/achievement');
        }
        exit();
    }

    public function achievementHistory()
    {
        $this->ensureSession();
        try {
            $achievements = Achievement::getAllAchievements($this->db);
            View::render('achievementHistory', ['achievements' => $achievements]);
        } catch (\Exception $e) {
            $_SESSION['error'] = "An error occurred while fetching achievement history.";
            header('Location: /dashboard');
            exit();
        }
    }

    public function showSubmissionForm()
    {
        $data = [
            'lecturers' => User::getAllActiveLecturers($this->db),
            'students' => User::getAllActiveStudents($this->db),
            'competitionLevels' => Achievement::getCompetitionLevels(),
            'competitionRanks' => Achievement::getCompetitionRanks()
        ];

        var_dump($data);

        View::render('achievement-submission', $data);
    }
}
