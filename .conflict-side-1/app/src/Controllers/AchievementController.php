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
        $this->ensureSession(); // Initialize session for all controller methods
    }

    private function ensureSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function achievementHistory()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }

        // Get achievements from database based on user ID
        $achievements = Achievement::getAchievementsByUserId($this->db, $_SESSION['user']['id']);

        // Convert rank and level IDs to names
        foreach ($achievements as &$achievement) {
            $achievement['CompetitionRankName'] = Achievement::getCompetitionRankName((int)$achievement['CompetitionRank']);
            $achievement['CompetitionLevelName'] = Achievement::getCompetitionLevelName((int)$achievement['CompetitionLevel']);
        }

        // Send data to view
        View::render('achievement-history', [
            'achievements' => $achievements
        ]);
    }

    public function submissionForm()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }

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
        // Check if user is logged in
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }

        try {
            $userId = $_SESSION['user']['id'];
            $competitionType = trim($_POST['competitionType']);
            $competitionLevel = (int)$_POST['competitionLevel'];
            $competitionRank = (int)$_POST['competitionRank'];
            $competitionTitle = trim($_POST['competitionTitle']);
            $competitionTitleEnglish = trim($_POST['competitionTitleEnglish']);
            $competitionPlace = trim($_POST['competitionPlace']);
            $competitionPlaceEnglish = trim($_POST['competitionPlaceEnglish']);
            $competitionUrl = trim($_POST['competitionUrl']);
            $competitionStartDate = new \DateTime($_POST['competitionStartDate']);
            $competitionEndDate = new \DateTime($_POST['competitionEndDate']);
            $numberOfInstitutions = (int)$_POST['numberOfInstitutions'];
            $numberOfStudents = (int)$_POST['numberOfStudents'];
            $letterNumber = trim($_POST['letterNumber']);
            $letterDate = new \DateTime($_POST['letterDate']);

            // Validate required files
            if (!isset($_FILES['letterFile']) || !isset($_FILES['certificateFile']) || 
                !isset($_FILES['documentationFile']) || !isset($_FILES['posterFile'])) {
                throw new \Exception('All files are required');
            }

            $letterFile = $_FILES['letterFile'];
            $certificateFile = $_FILES['certificateFile'];
            $documentationFile = $_FILES['documentationFile'];
            $posterFile = $_FILES['posterFile'];

            // Calculate points based on competition level and rank
            $competitionPoints = $competitionLevel + $competitionRank;

            // Process supervisors
            $supervisors = [];
            if (isset($_POST['supervisors']) && is_array($_POST['supervisors'])) {
                foreach ($_POST['supervisors'] as $supervisorId) {
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

            $this->validateTeamMembers($teamMembers, $numberOfStudents);

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
            header('Location: /dashboard/achievement/history');
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /dashboard/achievement/form');
        }
        exit();
    }

    public function supervisorValidation()
    {
        // Check if user is supervisor
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'supervisor') {
            header('Location: /login');
            exit;
        }

        View::render('achievement-history-supervisor', []);
    }

    public function supervisorValidationProcess()
    {
        // Check if user is supervisor
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'supervisor') {
            header('Location: /login');
            exit;
        }

        $achievementId = (int)$_POST['achievementId'];
        $status = trim($_POST['status']);
        $note = trim($_POST['note']);

        try {
            Achievement::updateSupervisorValidation($this->db, $achievementId, $status, $note);
            $_SESSION['success'] = 'Validation updated successfully';
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /dashboard/achievement/supervisor');
        exit();
    }

    public function adminValidation()
    {
        // Check if user is admin
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        View::render('achievement-history-admin', []);
    }

    public function adminValidationProcess()
    {
        // Check if user is admin
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $achievementId = (int)$_POST['achievementId'];
        $status = trim($_POST['status']);
        $note = trim($_POST['note']);

        try {
            Achievement::updateAdminValidation($this->db, $achievementId, $status, $note);
            $_SESSION['success'] = 'Validation updated successfully';
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /dashboard/achievement/admin');
        exit();
    }

    public function edit($data) {
        // Verify if user is logged in
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }

        $id = (int)$data['id'];

        // For GET request - display the form
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            try {
                // Fetch the achievement data
                $achievement = Achievement::getAchievement($this->db, $id);
                
                // Verify if achievement exists and belongs to the user
                if (!$achievement || $achievement['UserId'] != $_SESSION['user']['id']) {
                    throw new \Exception('Prestasi tidak ditemukan atau Anda tidak memiliki akses.');
                }

                // Fetch related data
                $supervisors = Achievement::getSupervisorsByAchievementId($this->db, $id);
                $teamLeaders = Achievement::getTeamMembersByAchievementId($this->db, $id, 2); // Role 2 for leaders
                $teamMembers = Achievement::getTeamMembersByAchievementId($this->db, $id, 3); // Role 3 for members
                
                // Load other necessary data
                $lecturers = User::getAllActiveLecturers($this->db);
                $students = User::getAllActiveStudents($this->db);
                $competitionLevels = Achievement::getCompetitionLevels();
                $competitionRanks = Achievement::getCompetitionRanks();

                // Display the view with the data
                View::render('achievement-edit', [
                    'achievement' => $achievement,
                    'supervisors' => $supervisors,
                    'teamLeaders' => $teamLeaders,
                    'teamMembers' => $teamMembers,
                    'lecturers' => $lecturers,
                    'students' => $students,
                    'competitionLevels' => $competitionLevels,
                    'competitionRanks' => $competitionRanks
                ]);
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: /dashboard/achievement/history');
                exit;
            }
        }
        
        // For POST request - handle the form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $achievementId = (int)$_POST['achievementId'];
                
                // Verify ownership again
                $achievement = Achievement::getAchievement($this->db, $achievementId);
                if (!$achievement || $achievement['UserId'] != $_SESSION['user']['id']) {
                    throw new \Exception('Prestasi tidak ditemukan atau Anda tidak memiliki akses.');
                }

                // Process the form data
                $updateData = [
                    'CompetitionTitle' => trim($_POST['competitionTitle']),
                    'CompetitionTitleEnglish' => trim($_POST['competitionTitleEnglish']),
                    'CompetitionType' => trim($_POST['competitionType']),
                    'CompetitionLevel' => (int)$_POST['competitionLevel'],
                    'CompetitionRank' => (int)$_POST['competitionRank'],
                    'CompetitionPlace' => trim($_POST['competitionPlace']),
                    'CompetitionPlaceEnglish' => trim($_POST['competitionPlaceEnglish']),
                    'CompetitionUrl' => trim($_POST['competitionUrl']),
                    'CompetitionStartDate' => $_POST['competitionStartDate'],
                    'CompetitionEndDate' => $_POST['competitionEndDate'],
                    'NumberOfInstitutions' => (int)$_POST['numberOfInstitutions'],
                    'NumberOfStudents' => (int)$_POST['numberOfStudents'],
                    'LetterNumber' => trim($_POST['letterNumber']),
                    'LetterDate' => $_POST['letterDate']
                ];

                // Handle file uploads if new files are provided
                if (!empty($_FILES['letterFile']['name'])) {
                    $updateData['LetterFile'] = Achievement::handleFileUpload($_FILES['letterFile'], 'letters');
                }
                if (!empty($_FILES['certificateFile']['name'])) {
                    $updateData['CertificateFile'] = Achievement::handleFileUpload($_FILES['certificateFile'], 'certificates');
                }
                if (!empty($_FILES['documentationFile']['name'])) {
                    $updateData['DocumentationFile'] = Achievement::handleFileUpload($_FILES['documentationFile'], 'documentation');
                }
                if (!empty($_FILES['posterFile']['name'])) {
                    $updateData['PosterFile'] = Achievement::handleFileUpload($_FILES['posterFile'], 'posters');
                }

                // Update the achievement
                $success = Achievement::updateAchievement($this->db, $achievementId, $updateData);
                
                // Update supervisors and team members
                if ($success) {
                    // Update supervisors
                    if (isset($_POST['supervisors'])) {
                        Achievement::updateSupervisors($this->db, $achievementId, $_POST['supervisors']);
                    }
                    
                    // Update team members
                    if (isset($_POST['teamMembers']) && isset($_POST['teamMemberRoles'])) {
                        $teamData = array_map(function($member, $role) {
                            return ['memberId' => $member, 'role' => $role];
                        }, $_POST['teamMembers'], $_POST['teamMemberRoles']);
                        Achievement::updateTeamMembers($this->db, $achievementId, $teamData);
                    }

                    $_SESSION['success'] = 'Prestasi berhasil diperbarui.';
                } else {
                    throw new \Exception('Gagal memperbarui prestasi.');
                }

                header('Location: /dashboard/achievement/history');
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: /dashboard/achievement/history');
            }
            exit;
        }
    }

    public function editFormProcess($data)
    {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }

        $achievementId = (int)$data['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Verify ownership
                $achievement = Achievement::getAchievement($this->db, $achievementId);
                if (!$achievement) {
                    throw new \Exception('Prestasi tidak ditemukan.');
                }

                // Check if user owns this achievement
                if ($achievement['UserId'] != $_SESSION['user']['id']) {
                    throw new \Exception('Anda tidak memiliki akses untuk mengedit prestasi ini.');
                }

                // Check if achievement is still in PENDING status
                if ($achievement['SupervisorValidationStatus'] !== 'PENDING' || 
                    $achievement['AdminValidationStatus'] !== 'PENDING') {
                    throw new \Exception('Hanya prestasi dengan status PENDING yang dapat diedit.');
                }

                // Prepare update data
                $updateData = [
                    'CompetitionType' => trim($_POST['competitionType']),
                    'CompetitionLevel' => (int)$_POST['competitionLevel'],
                    'CompetitionRank' => (int)$_POST['competitionRank'],
                    'CompetitionTitle' => trim($_POST['competitionTitle']),
                    'CompetitionTitleEnglish' => trim($_POST['competitionTitleEnglish']),
                    'CompetitionPlace' => trim($_POST['competitionPlace']),
                    'CompetitionPlaceEnglish' => trim($_POST['competitionPlaceEnglish']),
                    'CompetitionUrl' => trim($_POST['competitionUrl']),
                    'CompetitionStartDate' => $_POST['competitionStartDate'],
                    'CompetitionEndDate' => $_POST['competitionEndDate'],
                    'NumberOfInstitutions' => (int)$_POST['numberOfInstitutions'],
                    'NumberOfStudents' => (int)$_POST['numberOfStudents'],
                    'LetterNumber' => trim($_POST['letterNumber']),
                    'LetterDate' => $_POST['letterDate']
                ];

                // Handle file uploads if new files are provided
                if (!empty($_FILES['letterFile']['name'])) {
                    $updateData['LetterFile'] = Achievement::handleFileUpload($_FILES['letterFile'], 'letters');
                }
                if (!empty($_FILES['certificateFile']['name'])) {
                    $updateData['CertificateFile'] = Achievement::handleFileUpload($_FILES['certificateFile'], 'certificates');
                }
                if (!empty($_FILES['documentationFile']['name'])) {
                    $updateData['DocumentationFile'] = Achievement::handleFileUpload($_FILES['documentationFile'], 'documentation');
                }
                if (!empty($_FILES['posterFile']['name'])) {
                    $updateData['PosterFile'] = Achievement::handleFileUpload($_FILES['posterFile'], 'posters');
                }

                // Update the achievement
                $success = Achievement::updateAchievement($this->db, $achievementId, $updateData);
                
                // Update supervisors and team members
                if ($success) {
                    // Update supervisors
                    if (isset($_POST['supervisors'])) {
                        Achievement::updateSupervisors($this->db, $achievementId, $_POST['supervisors']);
                    }
                    
                    // Update team members
                    if (isset($_POST['teamMembers']) && isset($_POST['teamMemberRoles'])) {
                        $teamData = array_map(function($member, $role) {
                            return ['memberId' => $member, 'role' => $role];
                        }, $_POST['teamMembers'], $_POST['teamMemberRoles']);
                        Achievement::updateTeamMembers($this->db, $achievementId, $teamData);
                    }

                    $_SESSION['success'] = 'Prestasi berhasil diperbarui.';
                } else {
                    throw new \Exception('Gagal memperbarui prestasi.');
                }

                header('Location: /dashboard/achievement/history');
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: /dashboard/achievement/history');
            }
            exit;
        }
    }

    public function deleteAchievement($data)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }

        $achievementId = (int)$data['id'];

        try {
            // Verify ownership
            $achievement = Achievement::getAchievement($this->db, $achievementId);
            if (!$achievement) {
                throw new \Exception('Prestasi tidak ditemukan.');
            }

            // Check if user owns this achievement
            if ($achievement['UserId'] != $_SESSION['user']['id']) {
                throw new \Exception('Anda tidak memiliki akses untuk menghapus prestasi ini.');
            }

            // Check if achievement is still in PENDING status
            if ($achievement['SupervisorValidationStatus'] !== 'PENDING' || 
                $achievement['AdminValidationStatus'] !== 'PENDING') {
                throw new \Exception('Hanya prestasi dengan status PENDING yang dapat dihapus.');
            }

            // Perform the delete
            if (Achievement::deleteAchievement($this->db, $achievementId)) {
                $_SESSION['success'] = 'Prestasi berhasil dihapus.';
            } else {
                throw new \Exception('Gagal menghapus prestasi.');
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /dashboard/achievement/history');
        exit;
    }

    private function validateTeamMembers($teamMembers, $numberOfStudents) {
        $hasPersonal = false;
        $hasTeam = false;

        // Validate number of students for personal achievement
        if ($numberOfStudents > 1) {
            foreach ($teamMembers as $member) {
                if ($member['role'] === 'Personal') {
                    throw new \Exception('Prestasi personal hanya dapat dipilih untuk jumlah peserta 1 orang.');
                }
            }
        }

        foreach ($teamMembers as $member) {
            if ($member['role'] === 'Personal') {
                $hasPersonal = true;
            } else {
                $hasTeam = true;
            }

            if ($hasPersonal && $hasTeam) {
                throw new \Exception('Prestasi tidak dapat berupa personal dan tim secara bersamaan.');
            }
        }

        if ($hasTeam) {
            $hasLeader = false;
            foreach ($teamMembers as $member) {
                if ($member['role'] === 'Ketua') {
                    if ($hasLeader) {
                        throw new \Exception('Tim hanya boleh memiliki satu ketua.');
                    }
                    $hasLeader = true;
                }
            }
            if (!$hasLeader) {
                throw new \Exception('Tim harus memiliki satu ketua.');
            }
        }
    }
}