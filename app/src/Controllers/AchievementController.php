<?php

namespace PrestaC\Controllers;

use DateTime;
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

    private function validateUser()
    {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function getTopAchievementsForGuest()
    {
        $topAchievements = Achievement::getTopAchievementsForGuest($this->db, 10);
        $topThreeAchievements = Achievement::getTopThreeAchievements($this->db);
        $levelChartData = Achievement::getCompetitionLevelCounts($this->db);
        $monthlyCompetitions = Achievement::getMonthlyCompetitionsCount($this->db);

        $currentPeriod = $this->getCurrentPeriod();

        View::render('guest', [
            'topAchievements' => $topAchievements,
            'topThreeAchievements' => $topThreeAchievements,
            'levelChartData' => $levelChartData,
            'monthlyCompetitions' => $monthlyCompetitions,
            'currentPeriod' => $currentPeriod
        ]);
    }

    public static function getCurrentPeriod(): ?array
    {
        $currentDate = new DateTime();
        $periods = self::getStudentPeriods(date('y') . '000000');

        foreach ($periods as $period) {
            $start = new DateTime($period['start']);
            $end = new DateTime($period['end']);

            if ($currentDate >= $start && $currentDate <= $end) {
                return $period;
            }
        }

        return null;
    }

    public function getStatusAchievementStudent()
    {
        $this->validateUser();

        $statusAchievement = [
            'PENDING',
            'APPROVED',
            'REJECTED'
        ];

        return $statusAchievement;
    }

    public static function getStudentPeriods($username)
    {
        $startYear = (int)substr($username, 0, 2) + 2000;
        $currentDate = new DateTime();
        $periods = [];

        for ($i = 0; $i < 4; $i++) {
            $year = $startYear + $i;

            //based on 2023/2024 academic year
            // Odd semester: Aug 28 to Jan 26
            $oddSemesterStart = new DateTime("$year-08-28");
            $oddSemesterEnd = new DateTime(($year + 1) . "-01-26");

            // Even semester: Feb 12 to Aug 02
            $evenSemesterStart = new DateTime(($year + 1) . "-02-12");
            $evenSemesterEnd = new DateTime(($year + 1) . "-08-02");

            if ($currentDate >= $oddSemesterStart) {
                $periods[] = [
                    'label' => "$year/" . ($year + 1) . " Ganjil",
                    'start' => $oddSemesterStart->format('Y-m-d'),
                    'end' => $oddSemesterEnd->format('Y-m-d')
                ];
            }

            if ($currentDate >= $evenSemesterStart) {
                $periods[] = [
                    'label' => "$year/" . ($year + 1) . " Genap",
                    'start' => $evenSemesterStart->format('Y-m-d'),
                    'end' => $evenSemesterEnd->format('Y-m-d')
                ];
            }
        }

        return $periods;
    }

    public function achievementHistory()
    {
        $this->validateUser();

        $id = $_SESSION['user']['id'];
        $username = $_SESSION['user']['username'];

        $periods = $this->getStudentPeriods($username);
        $statusAchievement = $this->getStatusAchievementStudent();

        $achievements = Achievement::getAchievementsByUserId($this->db, $id, [
            'start' => isset($_GET['start']) ? $_GET['start'] : null,
            'end' => isset($_GET['end']) ? $_GET['end'] : null,
            'status' => isset($_GET['status']) ? $_GET['status'] : null
        ]);

        // Convert rank and level IDs to names
        foreach ($achievements as &$achievement) {
            $achievement['CompetitionRankName'] = Achievement::getCompetitionRankName((int)$achievement['CompetitionRank']) ?? 'Unknown';
            $achievement['CompetitionLevelName'] = Achievement::getCompetitionLevelName((int)$achievement['CompetitionLevel']) ?? 'Unknown';
        }

        // Render the view with the filtered achievements
        View::render('achievement-history', [
            'achievements' => $achievements,
            'periods' => $periods,
            'statusAchievement' => $statusAchievement
        ]);
    }

    public function submissionForm()
    {
        $this->validateUser();

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
        $this->validateUser();
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
            $requiredFiles = [
                'letterFile',
                'certificateFile',
                'documentationFile',
                'posterFile'
            ];

            $files = [];
            foreach ($requiredFiles as $fileKey) {
                if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] === UPLOAD_ERR_NO_FILE) {
                    throw new \Exception("$fileKey is required");
                }
                $files[$fileKey] = $_FILES[$fileKey];
            }

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
                $files['letterFile'],
                $files['certificateFile'],
                $files['documentationFile'],
                $files['posterFile'],
                $competitionPoints,
                new \DateTime(),
                new \DateTime(),
                null,
                'PENDING',
                null,
                null,
                null
            );

            $achievementId = $achievement->saveAchievement($this->db, $supervisors, $teamMembers);
            $_SESSION['success'] = "Achievement saved successfully with ID: " . $achievementId;
            header('Location: /dashboard/achievement/history');
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $_SESSION['form_data'] = $_POST;
            header('Location: /dashboard/achievement/form');
        }
        exit();
    }

    public function edit($data)
    {
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
                $achievement = Achievement::getAchievementById($this->db, $id);

                // Verify if achievement exists and belongs to the user
                // if (!$achievement || $achievement['UserId'] != $_SESSION['user']['id']) {
                //     throw new \Exception('Prestasi tidak ditemukan atau Anda tidak memiliki akses.');
                // }

                // Fetch related data
                $supervisors = Achievement::getSupervisorsByAchievementId($this->db, $id);
                $teamLeaders = Achievement::getTeamMembersByAchievementId($this->db, $id, 2); // Role 2 for leaders
                $teamMembers = Achievement::getTeamMembersByAchievementId($this->db, $id, 3); // Role 3 for members
                $teamMembersPersonal = Achievement::getTeamMembersByAchievementId($this->db, $id, 4); // Role 4 for personal

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
                    'teamMembersPersonal' => $teamMembersPersonal,
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
                $achievement = Achievement::getAchievementById($this->db, $achievementId);
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
                        $teamData = array_map(function ($member, $role) {
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

    public function viewAchievement($data)
    {
        $achievementId = (int)$data['id'];
        $achievement = Achievement::getAchievementById($this->db, $achievementId);
        $achievement['CompetitionRankName'] = Achievement::getCompetitionRankName((int)$achievement['CompetitionRank']);
        $achievement['CompetitionLevelName'] = Achievement::getCompetitionLevelName((int)$achievement['CompetitionLevel']);
        $supervisors = Achievement::getSupervisorsByAchievementId($this->db, $achievementId);
        $teamLeaders = Achievement::getTeamMembersByAchievementId($this->db, $achievementId, 2); // Role 2 for leaders
        $teamMembers = Achievement::getTeamMembersByAchievementId($this->db, $achievementId, 3); // Role 3 for members
        $teamMembersPersonal = Achievement::getTeamMembersByAchievementId($this->db, $achievementId, 4); // Role 4 for personal

        View::render('viewAchievement', [
            'achievement' => $achievement,
            'supervisors' => $supervisors,
            'teamLeaders' => $teamLeaders,
            'teamMembers' => $teamMembers,
            'teamMembersPersonal' => $teamMembersPersonal
        ]);
    }

    private function validateDates($competitionStartDate, $competitionEndDate, $letterDate)
    {
        $today = new \DateTime();
        $currentDate = $today->format('Y-m-d');

        if ($competitionStartDate > $currentDate) {
            throw new \Exception('Tanggal mulai kompetisi tidak boleh lebih dari tanggal saat ini.');
        }

        if ($competitionEndDate > $currentDate) {
            throw new \Exception('Tanggal selesai kompetisi tidak boleh lebih dari tanggal saat ini.');
        }

        if ($letterDate > $currentDate) {
            throw new \Exception('Tanggal surat tidak boleh lebih dari tanggal saat ini.');
        }
    }

    public function editFormProcess($data)
    {
        $this->validateUser();
        $achievementId = (int)$data['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $achievement = Achievement::getAchievementById($this->db, $achievementId);
                if (!$achievement) {
                    throw new \Exception('Prestasi tidak ditemukan.');
                }

                if ($achievement['UserId'] != $_SESSION['user']['id']) {
                    throw new \Exception('Anda tidak memiliki akses untuk mengedit prestasi ini.');
                }

                // Check if achievement is still in PENDING or REJECTED status
                if ($achievement['AdminValidationStatus'] != 'PENDING' && $achievement['AdminValidationStatus'] != 'REJECTED') {
                    throw new \Exception('Hanya prestasi dengan status PENDING atau REJECTED yang dapat diedit.');
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
                    'LetterDate' => $_POST['letterDate'],
                    'UpdatedAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ];

                // Validate dates
                $this->validateDates(
                    $_POST['competitionStartDate'],
                    $_POST['competitionEndDate'],
                    $_POST['letterDate']
                );

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

                // Validate team members
                $numberOfStudents = (int)$_POST['numberOfStudents'];
                $this->validateTeamMembers($teamMembers, $numberOfStudents); // Panggil fungsi validasi

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
                        $teamData = array_map(function ($member, $role) {
                            return ['memberId' => $member, 'role' => $role];
                        }, $_POST['teamMembers'], $_POST['teamMemberRoles']);
                        Achievement::updateTeamMembers($this->db, $achievementId, $teamData);
                    }

                    if ($achievement['AdminValidationStatus'] === 'REJECTED') {
                        Achievement::updateRejectedAdminValidation($this->db, $achievementId, 'PENDING');
                    }

                    $_SESSION['success'] = 'Prestasi berhasil diperbarui.';
                    header('Location: /dashboard/achievement/history');
                } else {
                    throw new \Exception('Gagal memperbarui prestasi.');
                }
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                $_SESSION['form_data'] = $_POST;
                header('Location: /dashboard/achievement/edit/' . $achievementId);
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
            $achievement = Achievement::getAchievementById($this->db, $achievementId);
            if (!$achievement) {
                throw new \Exception('Prestasi tidak ditemukan.');
            }

            if ($_SESSION['user']['role'] !== 1 && $achievement['UserId'] != $_SESSION['user']['id']) {
                throw new \Exception('Anda tidak memiliki akses untuk menghapus prestasi ini.');
            }

            if ($_SESSION['user']['role'] !== 1 && $achievement['AdminValidationStatus'] !== 'PENDING') {
                throw new \Exception('Hanya prestasi dengan status PENDING yang dapat dihapus.');
            }

            if (Achievement::deleteAchievement($this->db, $achievementId)) {
                $_SESSION['success'] = 'Prestasi berhasil dihapus.';
            } else {
                throw new \Exception('Gagal menghapus prestasi.');
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        if ($_SESSION['user']['role'] === 1) {
            header('Location: /admin/achievement/history');
        } else {
            header('Location: /dashboard/achievement/history');
        }
        exit;
    }

    private function validateTeamMembers($teamMembers, $numberOfStudents)
    {
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

    //admin
    public function adminValidationProcess()
    {
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 1) {
            header('Location: /login');
            exit;
        }

        $achievementId = (int)$_POST['achievementId'];
        $status = $_POST['APPROVED'] ? 'APPROVED' : 'REJECTED';
        $note = trim($_POST['adminComment']);

        try {
            Achievement::updateAdminValidation($this->db, $achievementId, $status, $note);
            $_SESSION['success'] = 'Validation updated successfully';
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /admin/achievement/history');
        exit();
    }

    public function adminHistory()
    {
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 1) {
            header('Location: /login');
            exit;
        }

        $statusAchievement = $this->getStatusAchievementStudent();
        $filter = [
            'status' => isset($_GET['status']) ? $_GET['status'] : null,
            'start' => isset($_GET['start']) ? $_GET['start'] : null,
            'end' => isset($_GET['end']) ? $_GET['end'] : null,
        ];

        if ($_SESSION['user']['fullName'] == 'Admin Pusat') {
            $achievements = Achievement::getAllAchievements($this->db, $filter);
        } elseif ($_SESSION['user']['fullName'] == 'Admin Program Studi Sistem Informasi Bisnis') {
            $filter['studentMajor'] = 2;
            $achievements = Achievement::getAllAchievements($this->db, $filter);
        } else {
            $filter['studentMajor'] = 1;
            $achievements = Achievement::getAllAchievements($this->db, $filter);
        }

        foreach ($achievements as &$achievement) {
            $achievement['CompetitionRankName'] = Achievement::getCompetitionRankName((int)$achievement['CompetitionRank']);
            $achievement['CompetitionLevelName'] = Achievement::getCompetitionLevelName((int)$achievement['CompetitionLevel']);
        }

        View::render('achievement-history-admin', [
            'achievements' => $achievements,
            'statusAchievement' => $statusAchievement,
        ]);
    }

    public function adminView($data)
    {
        $achievementId = (int)$data['id'];
        $achievement = Achievement::getAchievementById($this->db, $achievementId);
        View::render('viewAchievement', ['achievement' => $achievement]);
    }
}
