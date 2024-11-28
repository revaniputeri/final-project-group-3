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

    public function achievementHistory()
    {
        $this->ensureSession();

        // Ambil data achievement dari database berdasarkan user ID
        $achievements = Achievement::getAchievementsByUserId($this->db, $_SESSION['user']['id']);

        // Konversi rank dan level ID ke nama yang sesuai
        foreach ($achievements as &$achievement) {
            $achievement['CompetitionRankName'] = Achievement::getCompetitionRankName((int)$achievement['CompetitionRank']);
            $achievement['CompetitionLevelName'] = Achievement::getCompetitionLevelName((int)$achievement['CompetitionLevel']);
        }

        // Kirim data ke view
        View::render('achievement-history', [
            'achievements' => $achievements
        ]);
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
            header('Location: /dashboard/achievement/history');
        }
        exit();
    }

    public function supervisorValidation()
    {
        View::render('achievement-history-supervisor', []);
    }


    public function supervisorValidationProcess()
    {
        $this->ensureSession();
        $achievementId = $_POST['achievementId'];
        $status = $_POST['status'];
        $note = $_POST['note'];

        Achievement::updateSupervisorValidation($this->db, $achievementId, $status, $note);
    }

    public function adminValidation()
    {
        View::render('achievement-history-admin', []);
    }

    public function adminValidationProcess()
    {
        $this->ensureSession();
        $achievementId = $_POST['achievementId'];
        $status = $_POST['status'];
        $note = $_POST['note'];

        Achievement::updateAdminValidation($this->db, $achievementId, $status, $note);
    }

    public function editForm($id)
    {
        $this->ensureSession();

        // Convert $id to integer
        $achievementId = (int)$id;

        // Get achievement data
        $achievement = Achievement::getAchievement($this->db, $achievementId);

        // Check if achievement exists and belongs to current user
        if (!$achievement || $achievement['UserId'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Achievement not found or access denied";
            header('Location: /dashboard/achievement/history');
            exit();
        }

        // Check if achievement is still editable
        if (
            $achievement['SupervisorValidationStatus'] !== 'PENDING' ||
            $achievement['AdminValidationStatus'] !== 'PENDING'
        ) {
            $_SESSION['error'] = "Achievement cannot be edited as it has been validated";
            header('Location: /dashboard/achievement/history');
            exit();
        }

        // Get additional data needed for the form
        $data = [
            'achievement' => $achievement,
            'lecturers' => User::getAllActiveLecturers($this->db),
            'students' => User::getAllActiveStudents($this->db),
            'competitionLevels' => Achievement::getCompetitionLevels(),
            'competitionRanks' => Achievement::getCompetitionRanks(),
            'supervisors' => Achievement::getUsersByRole($this->db, $achievementId, 1), // 1 = ROLE_SUPERVISOR
            'teamMembers' => Achievement::getUsersByRole($this->db, $achievementId, 3)  // 3 = ROLE_TEAM_MEMBER
        ];

        View::render('achievement-edit', $data);
    }

    public function editFormProcess($id)
    {
        $this->ensureSession();

        try {
            // Convert $id to integer
            $achievementId = (int)$id;

            // First verify the achievement exists and is editable
            $existingAchievement = Achievement::getAchievement($this->db, $achievementId);
            if (
                !$existingAchievement ||
                $existingAchievement['UserId'] != $_SESSION['user']['id'] ||
                $existingAchievement['SupervisorValidationStatus'] !== 'PENDING' ||
                $existingAchievement['AdminValidationStatus'] !== 'PENDING'
            ) {
                throw new \Exception("Achievement cannot be edited");
            }

            // Process the form data similar to submissionFormProcess
            $achievement = new Achievement(
                $_SESSION['user']['id'],
                $_POST['competitionType'],
                (int)$_POST['competitionLevel'],
                $_POST['competitionTitle'],
                $_POST['competitionTitleEnglish'],
                $_POST['competitionPlace'],
                $_POST['competitionPlaceEnglish'],
                $_POST['competitionUrl'],
                new \DateTime($_POST['competitionStartDate']),
                new \DateTime($_POST['competitionEndDate']),
                (int)$_POST['competitionRank'],
                $_POST['numberOfInstitutions'],
                $_POST['numberOfStudents'],
                $_POST['letterNumber'],
                new \DateTime($_POST['letterDate']),
                $_FILES['letterFile'] ?? null,
                $_FILES['certificateFile'] ?? null,
                $_FILES['documentationFile'] ?? null,
                $_FILES['posterFile'] ?? null,
                0, // Will be calculated
                new \DateTime(),
                new \DateTime(),
                $achievementId
            );

            // Process supervisors and team members
            $supervisors = [];
            if (isset($_POST['supervisors']) && is_array($_POST['supervisors'])) {
                foreach ($_POST['supervisors'] as $supervisorId) {
                    if (!empty($supervisorId)) {
                        $supervisors[] = (int)$supervisorId;
                    }
                }
            }

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

            // Update the achievement
            $achievement->updateAchievement($this->db, $achievementId, $supervisors, $teamMembers);
            $_SESSION['success'] = "Achievement updated successfully";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        if (isset($_SESSION['error'])) {
            header("Location: /dashboard/achievement/edit/$achievementId");
        } else {
            header('Location: /dashboard/achievement/history');
        }
        exit();
    }
}
